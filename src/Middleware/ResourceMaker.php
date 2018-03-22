<?php

namespace Uzzal\Acl\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Route;
use Uzzal\Acl\Models\Resource;
use Uzzal\Acl\Models\Permission;

class ResourceMaker {

    /**
     *
     * @var Route
     */
    private $route;
    private $_controller_path_pattern = 'App\\\Http\\\Controllers';

    public function __construct(Route $route) {
        $this->route = $route;
        $prefix = config('acl.controller_namespace_prefix', 'App\Http\Controllers');
        $this->_controller_path_pattern = str_replace('\\', '\\\\\\', $prefix);
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
        $resource_id = sha1($action, false);
        $controller = $this->_getControllerName($action);
        $name = $request->getMethod().'::'.$this->_getActionName($action);

        if ($controller) {
            $resource = Resource::find($resource_id);
            if (!$resource && $name != 'Method') {

                Resource::create([
                            'resource_id' => $resource_id,
                            'name' => $controller . ' ' . $name,
                            'controller' => $controller,
                            'action' => $action
                ]);

                $this->_createPermission(1, $resource_id);
            }
        }

        return $next($request);
    }

    private function _createPermission($role_id, $resource_id){
        try{
            Permission::create(['role_id' => $role_id, 'resource_id' => $resource_id]);
        }catch (QueryException $e){}
    }

    /**
     * @des Namespace will be \Form\RegistrationController will be like Form-Registration
     * @param string $action
     * @return string
     */
    private function _getControllerName($action) {
        $pattern = '/'.$this->_controller_path_pattern.'\\\([a-zA-Z\\\]+)Controller\@/';
        preg_match($pattern, $action, $matches);

        if (count($matches) == 2) {
            return str_replace('\\', '-', $matches[1]);
        }

        return null;
    }

    /**
     *
     * @param string $action
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
