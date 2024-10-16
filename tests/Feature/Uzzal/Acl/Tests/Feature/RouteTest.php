<?php

namespace Uzzal\Acl\Tests\Feature;

use Uzzal\Acl\Tests\TestCase;
use Workbench\App\Models\User;
use Workbench\Database\Seeders\DatabaseSeeder;
use function Orchestra\Testbench\artisan;
use function Orchestra\Testbench\workbench_path;

class RouteTest extends TestCase
{
    protected function defineRoutes($router)
    {
        $router->get('/hello', function () {
            return 'Hello World';
        })->name('hello')->middleware('auth');
    }

    public function test_home_index_route(){
        artisan($this, 'migrate', ['--database' => 'testbench']);
        $this->seed([
            DatabaseSeeder::class
        ]);

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/hello');
        $response->assertStatus(200);
        $this->assertTrue(true);
    }
}
