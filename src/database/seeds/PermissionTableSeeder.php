<?php

use Illuminate\Database\Seeder;
use Uzzal\Acl\Models\Permission;

class PermissionTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {        
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\RoleController@index', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\RoleController@create', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\RoleController@edit', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\RoleController@destroy', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\RoleController@store', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\RoleController@update', false)]);
        
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\ResourceController@index', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\ResourceController@create', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\ResourceController@edit', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\ResourceController@destroy', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\ResourceController@store', false)]);
        Permission::create(['role_id'=>1,'resource_id' => sha1('Uzzal\Acl\Http\ResourceController@update', false)]);
    }
}

