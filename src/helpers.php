<?php

if (!function_exists('has')) {
    function allowed(array $resource)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
    }
}