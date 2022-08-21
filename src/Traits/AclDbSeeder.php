<?php

namespace Uzzal\Acl\Traits;

use Uzzal\Acl\Seeds\PermissionTableSeeder;
use Uzzal\Acl\Seeds\ResourceTableSeeder;
use Uzzal\Acl\Seeds\RoleTableSeeder;
use Uzzal\Acl\Seeds\UserRoleTableSeeder;

trait AclDbSeeder
{
    private function _seedAclTables(){
        $this->call([
            ResourceTableSeeder::class,
            RoleTableSeeder::class,
            UserRoleTableSeeder::class,
            PermissionTableSeeder::class
        ]);
    }
}