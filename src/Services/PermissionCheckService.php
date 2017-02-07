<?php

namespace Uzzal\Acl\Services;

use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Models\Resource;
use Uzzal\Acl\Models\UserRole;
use Auth;

/**
 * Description of PermissionCheckService
 *
 * @author Mahabubul Hasan Uzzal <codehasan@gmail.com>
 */
class PermissionCheckService {
        
    /**
     * 
     * @param int $userId
     * @return array
     */
    private static function _getUserRoles($userId){
        return array_flatten(UserRole::Where('user_id', $userId)->get(['role_id'])->toArray());
    }

    public static function canAccess($action, $user) {        
        $resource = Resource::where('action', '=', $action)
                ->select(['resource_id'])
                ->first();

        if (!$resource) {
            return false;
        }

        $roles = self::_getUserRoles($user->user_id);                
        return Permission::resource($resource->resource_id)->roles($roles)->select('permission_id')->exists();
    }

    private static $_resources = [];

    public static function getResources() {
        if (count(self::$_resources) == 0) {
            $rows = self::_getPermissionRows();

            foreach ($rows as $r) {
                self::$_resources[] = $r->resourceItem->action;
            }
        }

        return self::$_resources;
    }

    private static $_permission_rows = [];

    private static function _getPermissionRows() {
        if (count(self::$_permission_rows) == 0) {            
            $roles = [];
            if (Auth::user()) {                
                $roles = self::_getUserRoles(Auth::id());
            }            
            self::$_permission_rows = Permission::roles($roles)->get();            
        }

        return self::$_permission_rows;
    }

    private static $_resource_group = [];

    public static function getResourceGroup() {
        if (count(self::$_resource_group) == 0) {
            $rows = self::_getPermissionRows();
            foreach ($rows as $r) {
                self::$_resource_group[] = $r->resourceItem->controller;
            }

            self::$_resource_group = array_unique(self::$_resource_group);
        }

        return self::$_resource_group;
    }

    private static $_actionPrefix = 'App\\Http\\Controllers\\';

    /**
     *
     * @param string $action
     * @return boolean
     * @example
     * <code>
     * hasAccess('UserController@getIndex')
     * hasAccess('Form\RegistrationController@getIndex')
     * </code>
     */
    public static function hasAccess($action) {
        return in_array(self::$_actionPrefix . $action, self::getResources());
    }

    /**
     *
     * @param mix $group
     * @return boolean
     */
    public static function hasGroupAccess($group) {
        if (is_array($group)) {
            $resources = self::getResourceGroup();
            foreach ($group as $g) {
                if (in_array($g, $resources)) {
                    return true;
                }
            }
        } else {
            return in_array($group, self::getResourceGroup());
        }

        return false;
    }

}
