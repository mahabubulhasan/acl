<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Uzzal\Acl\Models\Role;
use Uzzal\Acl\Models\UserRole;
use Workbench\Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->create([
            'name' => 'Developer User',
            'email' => 'developer@example.com',
        ]);

        UserFactory::new()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        UserFactory::new()->create([
            'name' => 'Basic User',
            'email' => 'basic@example.com',
        ]);

        Role::create(['name' => 'Developer']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Basic']);

        UserRole::create(['user_id' => 1, 'role_id' => 1]);
        UserRole::create(['user_id' => 2, 'role_id' => 2]);
        UserRole::create(['user_id' => 3, 'role_id' => 3]);
    }
}
