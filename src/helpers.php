<?php

if (!function_exists('let')) {
    function let(array $resource)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
    }
}