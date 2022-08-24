<?php

namespace Uzzal\Acl\Traits;

use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Models\UserRole;

trait AccessControlled
{
    public function allowed(mixed $resource)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
    }

    public function allowedAny(mixed $group)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasGroupAccess($group);
    }

    public function hasRole(mixed $roles){
        return \Uzzal\Acl\Services\PermissionCheckService::hasRole($roles);
    }

    public function userRoles(){
        return $this->hasMany(UserRole::class, 'user_id', $this->primaryKey);
    }

    public function permissions(){
        return $this->hasManyThrough(
            Permission::class
            , UserRole::class
            , 'user_id'
            , 'role_id'
            , $this->primaryKey
            , 'role_id'
        );
    }

}