<?php

namespace Uzzal\Acl\Middleware;

use Closure;
use Illuminate\Routing\Route;
use Uzzal\Acl\Models\Resource;
use Uzzal\Acl\Models\Permission;

class ResourceMaker {

    /**
     *
     * @var Route
     */
    private $route;

    public function __construct(Route $route) {
        $this->route = $route;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $action = $this->route->getActionName();        
        $controller = $this->_getControllerName($action);
        $name = $request->getMethod().'::'.$this->_getActionName($action);
        
        if ($controller) {
            $resource = Resource::where('action', '=', $action)->get(['resource_id'])->first();
            if (!$resource && $name != 'Method') {

                $resource = Resource::create([
                            'name' => $controller . ' ' . $name,
                            'controller' => $controller,
                            'action' => $action
                ]);

                Permission::create(['role_id' => 1, 'resource_id' => $resource->resource_id]);
            }
        }

        return $next($request);
    }

    /**
     * @des Namespace will be \Form\RegistrationController will be like Form-Registration
     * @param string $action
     * @return string
     */
    private function _getControllerName($action) {
        $pattern = '/App\\\Http\\\Controllers\\\([a-zA-Z\\\]+)Controller\@/';
        preg_match($pattern, $action, $matches);

        if (count($matches) == 2) {
            return str_replace('\\', '-', $matches[1]);
        }

        return null;
    }

    /**
     *
     * @param type $action
     * @return string
     */
    private function _getActionName($action) {
        $pattern = '/([a-zA-Z]+)$/';
        preg_match($pattern, $action, $matches);
        
        if (count($matches) == 2) {
            return ucfirst($matches[1]);
        }

        return '';
    }

}
