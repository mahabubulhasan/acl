<?php

namespace Uzzal\Acl\Traits;

trait AccessControlled
{
    public function allowed(mixed $resource)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
    }
}