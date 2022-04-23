<?php

namespace Uzzal\Acl\Traits;

trait AccessControlled
{
    public function allowed(array $resource)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
    }
}