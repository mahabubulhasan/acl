<?php

namespace Uzzal\Acl\Traits;

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

}