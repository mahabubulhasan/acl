<?php

if (!function_exists('allowed')) {
    function allowed(mixed $resource)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
    }
}

if (!function_exists('allowedAny')) {
    function allowedAny(mixed $group)
    {
        return \Uzzal\Acl\Services\PermissionCheckService::hasGroupAccess($group);
    }
}

if (! function_exists('row_serial_start')) {
    /**
     *
     * @param type $paginator
     * @example
     * <code>
     * <?php $index = row_serial_start($rows) ?>
     * <td>{{$index++}}</td>
     * </code>
     */
    function row_serial_start($paginator){
        return (($paginator->currentPage()-1) * $paginator->perPage())+1;
    }
}