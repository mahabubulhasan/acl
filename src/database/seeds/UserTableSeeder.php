<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_create(['name' => 'Mahabubul Hasan', 'email' => 'uzzal@example.com', 'password' => bcrypt('123456'), 'is_active' => true]);
        $this->_create(['name' => 'Ethan Hunt', 'email' => 'ethan@example.com', 'password' => bcrypt('123456'), 'is_active' => true]);
    }

    private function _create(array $data)
    {
        return User::create($data);
    }

}