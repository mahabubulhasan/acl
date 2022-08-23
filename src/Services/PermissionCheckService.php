<?php

namespace Uzzal\Acl\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Models\UserRole;


class PermissionCheckService
{

    private static $_roles = null;
    private static $_resources = [];
    private static $_permission_rows = [];
    private static $_resource_group = [];

    private const ROUTE_NAME = 1;
    private const ACTION_NAME = 2;

    public static function canAccess($action, $user)
    {
        $roles = self::_getUserRoles($user->{$user->getKeyName()});
        return Permission::resource(sha1($action, false))->roles($roles)->exists();
    }

    private static function _getUserRoles($userId)
    {
        if (!self::$_roles) {
            self::$_roles = Arr::flatten(UserRole::Where('user_id', $userId)->get(['role_id'])->toArray());
        }
        return self::$_roles;
    }

    public static function hasAccess(mixed $resource)
    {
        if (is_array($resource) && count($resource)==2) {
            list($controller, $action) = $resource;
            return in_array($controller . '@' . $action, self::getResources());
        }

        $action = Route::getRoutes()->getByName($resource)?->action['uses'];
        return $action && in_array($action, self::getResources());
    }

    public static function getResources()
    {
        if (count(self::$_resources) == 0) {
            self::_computeResource();
        }

        return self::$_resources;
    }

    private static function _computeResource()
    {
        $rows = self::_getPermissionRows();
        foreach ($rows as $r) {
            if ($r->resourceItem) {
                self::$_resource_group[] = $r->resourceItem->controller;
                self::$_resources[] = $r->resourceItem->action;
            }
        }
        // all the controller's name as array based on role
        self::$_resource_group = array_unique(self::$_resource_group);
    }

    private static function _getPermissionRows()
    {
        if (count(self::$_permission_rows) == 0 && Auth::user()) {
            // get all the resource_id based on roles
            $roles = self::_getUserRoles(Auth::id());
            self::$_permission_rows = Permission::with('resourceItem')->roles($roles)->get();
        }

        return self::$_permission_rows;
    }

    public static function hasGroupAccess($group)
    {
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

    public static function getResourceGroup()
    {
        if (count(self::$_resource_group) == 0) {
            self::_computeResource();
        }

        return self::$_resource_group;
    }

}
