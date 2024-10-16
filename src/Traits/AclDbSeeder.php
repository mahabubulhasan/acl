<?php

namespace Uzzal\Acl\Traits;

use Uzzal\Acl\Seeds\RoleTableSeeder;
use Uzzal\Acl\Seeds\UserRoleTableSeeder;

trait AclDbSeeder
{
    private function _seedAclTables(){
        $this->call([
            RoleTableSeeder::class,
            UserRoleTableSeeder::class
        ]);
    }
}
