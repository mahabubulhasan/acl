<?php
/**
 * 
 * @param mix|string $action
 * @return bool
 * @example
 * <code>
 * @if(has_access('User\UserController@getIndex'))
 * OR
 * @if(has_access('UserController@getIndex'))
 * </code>
 */
function has_access($action){    
    return Uzzal\Acl\Services\PermissionCheckService::hasAccess($action);
}

/**
 * 
 * @param mix|string $group
 * @return bool
 * @example
 * <code>
 * @if(has_group_access(['User-User','User-Role','User-Resource']))
 * OR
 * @if(has_group_access('User-User'))
 * </code>
 */
function has_group_access($group){    
    return Uzzal\Acl\Services\PermissionCheckService::hasGroupAccess($group);
}

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

/**
 * @des returns the CSS class for form validation error.
 * @param array $errors
 * @param string $field
 * @return string
 */
function has_error($errors, $field){
    return ($errors->has($field))?'has-error':'';
}