<?php

use Illuminate\Database\Seeder;
use Uzzal\Acl\Models\Resource;

class ResourceTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\RoleController@index', false),'name'=>'Role GET::Index', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@index']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\RoleController@create', false),'name'=>'Role GET::Create', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@create']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\RoleController@edit', false),'name'=>'Role GET::Edit', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@edit']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\RoleController@destroy', false),'name'=>'Role GET::Destroy', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@destroy']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\RoleController@store', false),'name'=>'Role POST::Store', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@store']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\RoleController@update', false),'name'=>'Role POST::Update', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@update']);

        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\ResourceController@index', false),'name'=>'Resource GET::Index', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@index']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\ResourceController@create', false),'name'=>'Resource GET::Create', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@create']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\ResourceController@edit', false),'name'=>'Resource GET::Edit', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@edit']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\ResourceController@destroy', false),'name'=>'Resource GET::Destroy', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@destroy']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\ResourceController@store', false),'name'=>'Resource POST::Store', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@store']);
        Resource::create(['resource_id'=>sha1('Uzzal\Acl\Http\ResourceController@update', false),'name'=>'Resource POST::Update', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@update']);
    }

}
