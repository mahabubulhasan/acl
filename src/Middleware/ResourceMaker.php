<?php

namespace Uzzal\Acl\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Route;
use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Models\Resource;

class ResourceMaker
{

    private $route;
    private $_controller_path_pattern = 'App\\\Http\\\Controllers';

    public function __construct(Route $route)
    {
        $this->route = $route;
        $prefix = config('acl.controller_namespace_prefix', 'App\Http\Controllers');
        $this->_controller_path_pattern = str_replace('\\', '\\\\\\', $prefix);
    }

    public function handle($request, Closure $next)
    {
        if(config('app.env')=='production'){
            return $next($request);
        }

        $action = $this->route->getActionName();
        if($action == 'Closure'){
            return $next($request);
        }

        $resource_id = sha1($action, false);
        $controller = $this->_getControllerName($action);
        $name = $controller . ' ' . $request->getMethod() . '::' . $this->_getActionName($action);

        if ($controller) {
            $resource = Resource::find($resource_id);
            if (!$resource) {

                Resource::create([
                    'resource_id' => $resource_id,
                    'name' => $name,
                    'controller' => $controller,
                    'action' => $action
                ]);

                $this->_createPermission(1, $resource_id);
            }
        }

        return $next($request);
    }

    private function _getControllerName($action)
    {
        $pattern = '/' . $this->_controller_path_pattern . '\\\([a-zA-Z0-9_\\\]+)Controller\@/';
        preg_match($pattern, $action, $matches);

        if (count($matches) == 2) {
            return str_replace('\\', '-', $matches[1]);
        }

        return null;
    }

    private function _getActionName($action)
    {
        $pattern = '/([a-zA-Z0-9_]+)$/';
        preg_match($pattern, $action, $matches);

        if (count($matches) == 2) {
            return ucfirst($matches[1]);
        }

        return '';
    }

    private function _createPermission($role_id, $resource_id)
    {
        try {
            Permission::create(['role_id' => $role_id, 'resource_id' => $resource_id]);
        } catch (QueryException $e) {
        }
    }

}
