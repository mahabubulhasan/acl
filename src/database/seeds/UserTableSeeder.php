<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder {
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->_create(['name' => 'Mahabubul Hasan', 'role_id' => 1, 'email' => 'mahabubul.hasan@dnet.org.bd', 'password' => bcrypt('6digit'),'is_active'=>true]);
        $this->_create(['name' => 'Rahat Bashir', 'role_id' => 2, 'email' => 'rahat@dnet.org.bd', 'password' => bcrypt('123456'),'is_active'=>true]);
    }
    
    private function _create(array $data){
        return User::create($data);
    }

}