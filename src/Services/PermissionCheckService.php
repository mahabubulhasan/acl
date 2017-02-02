<?php
namespace Uzzal\Acl\Services;

use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Models\Resource;
use Auth;

/**
 * Description of PermissionCheckService
 *
 * @author Mahabubul Hasan Uzzal <mahabubul.hasan@dnet.org.bd>
 */
class PermissionCheckService {
    public static function canAccess($action, $user){
        $resource = Resource::where('action','=', $action)                    
                    ->select(['resource_id'])
                    ->first();
        
        if(!$resource){
            return false;
        }

        return Permission::resource($resource->resource_id)->role($user->role_id)->select('permission_id')->exists();
    }

    private static $_resources = [];
    public static function getResources(){
        if(count(self::$_resources)==0){
            $rows = self::_getPermissionRows();

            foreach($rows as $r){
                self::$_resources[] = $r->resourceItem->action;
            }
        }

        return self::$_resources;
    }

    private static $_permission_rows=[];
    private static function _getPermissionRows(){
        if(count(self::$_permission_rows)==0){
            $role_id = 0;
            if(Auth::user()){
                $role_id = Auth::user()->role_id;
            }
            self::$_permission_rows = Permission::whereRoleId($role_id)->get();
        }

        return self::$_permission_rows;
    }

    private static $_resource_group = [];
    public static function getResourceGroup(){
        if(count(self::$_resource_group)==0){
            $rows = self::_getPermissionRows();
            foreach($rows as $r){
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
    public static function hasAccess($action){
        return in_array(self::$_actionPrefix.$action, self::getResources());
    }

    /**
     *
     * @param mix $group
     * @return boolean
     */
    public static function hasGroupAccess($group){
        if(is_array($group)){
            $resources = self::getResourceGroup();
            foreach($group as $g){
                if(in_array($g, $resources)){
                    return true;
                }
            }
        }else{
            return in_array($group, self::getResourceGroup());
        }

        return false;
    }
}
