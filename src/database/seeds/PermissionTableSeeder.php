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
        Permission::create(['role_id'=>1,'resource_id'=>1]);
        Permission::create(['role_id'=>1,'resource_id'=>2]);
        Permission::create(['role_id'=>1,'resource_id'=>3]);
        Permission::create(['role_id'=>1,'resource_id'=>4]);
        Permission::create(['role_id'=>1,'resource_id'=>5]);
        Permission::create(['role_id'=>1,'resource_id'=>6]);
        
        Permission::create(['role_id'=>1,'resource_id'=>7]);
        Permission::create(['role_id'=>1,'resource_id'=>8]);
        Permission::create(['role_id'=>1,'resource_id'=>9]);
        Permission::create(['role_id'=>1,'resource_id'=>10]);
        Permission::create(['role_id'=>1,'resource_id'=>11]);
        Permission::create(['role_id'=>1,'resource_id'=>12]);
        
        Permission::create(['role_id'=>1,'resource_id'=>13]);
        Permission::create(['role_id'=>1,'resource_id'=>14]);
        Permission::create(['role_id'=>1,'resource_id'=>15]);
        Permission::create(['role_id'=>1,'resource_id'=>16]);
        Permission::create(['role_id'=>1,'resource_id'=>17]);
        Permission::create(['role_id'=>1,'resource_id'=>18]);
        Permission::create(['role_id'=>1,'resource_id'=>19]);
    }
}

