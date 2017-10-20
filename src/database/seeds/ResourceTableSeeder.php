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
        Resource::create(['name'=>'Role GET::Index', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@index']);
        Resource::create(['name'=>'Role GET::Create', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@create']);
        Resource::create(['name'=>'Role GET::Edit', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@edit']);
        Resource::create(['name'=>'Role GET::Destroy', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@destroy']);
        Resource::create(['name'=>'Role POST::Store', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@store']);
        Resource::create(['name'=>'Role POST::Update', 'controller'=>'User-Role', 'action'=>'Uzzal\Acl\Http\RoleController@update']);
        
        Resource::create(['name'=>'Resource GET::Index', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@index']);
        Resource::create(['name'=>'Resource GET::Create', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@create']);
        Resource::create(['name'=>'Resource GET::Edit', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@edit']);
        Resource::create(['name'=>'Resource GET::Destroy', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@destroy']);
        Resource::create(['name'=>'Resource POST::Store', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@store']);
        Resource::create(['name'=>'Resource POST::Update', 'controller'=>'User-Resource', 'action'=>'Uzzal\Acl\Http\ResourceController@update']);
    }

}
