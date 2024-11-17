<?php

namespace Uzzal\Acl\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use Uzzal\Acl\Middleware\AuthenticateWithAcl;
use Uzzal\Acl\Tests\TestCase;
use Workbench\App\Http\Controllers\HomeController;
use Workbench\App\Models\User;
use Workbench\Database\Seeders\DatabaseSeeder;
use function Orchestra\Testbench\artisan;

class RoutePermissionTest extends TestCase
{
    use RefreshDatabase;

    private const DEVELOPER_USER_ID = 1;
    private const ADMIN_USER_ID = 2;
    private const BASIC_USER_ID = 3;

    protected function defineRoutes($router)
    {
        $router->resource('home', HomeController::class)->middleware(AuthenticateWithAcl::class);
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->withMiddleware([AuthenticateWithAcl::class]);
    }

    private function prepareDatabase()
    {
        artisan($this, 'migrate', ['--database' => 'testbench']);
        $this->seed([
            DatabaseSeeder::class
        ]);
        artisan($this, 'acl:resource');
    }

    #[RunInSeparateProcess]
    public function test_developer_role_permissions()
    {
        $this->prepareDatabase();

        $user = User::find(self::DEVELOPER_USER_ID);
        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertContent('home.index');
        $response->assertStatus(200);

        $response = $this->post('/home');
        $response->assertContent('home.store');
        $response->assertStatus(200);

        $response = $this->get('/home/create');
        $response->assertContent('home.create');
        $response->assertStatus(200);

        $response = $this->get('/home/id');
        $response->assertContent('home.show');
        $response->assertStatus(200);

        $response = $this->get('/home/id/edit');
        $response->assertContent('home.edit');
        $response->assertStatus(200);

        $response = $this->put('home/id');
        $response->assertContent('home.update');
        $response->assertStatus(200);

        $response = $this->delete('home/id');
        $response->assertContent('home.destroy');
        $response->assertStatus(200);
    }

    #[RunInSeparateProcess]
    public function test_admin_role_permissions()
    {
        $this->prepareDatabase();

        $user = User::find(self::ADMIN_USER_ID);
        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertContent('home.index');
        $response->assertStatus(200);

        $response = $this->post('/home');
        $response->assertContent('home.store');
        $response->assertStatus(200);

        $response = $this->get('/home/create');
        $response->assertContent('home.create');
        $response->assertStatus(200);

        $response = $this->get('/home/id');
        $response->assertContent('home.show');
        $response->assertStatus(200);

        $response = $this->get('/home/id/edit');
        $response->assertContent('home.edit');
        $response->assertStatus(200);

        $response = $this->put('home/id');
        $response->assertContent('home.update');
        $response->assertStatus(200);

        $response = $this->delete('home/id');
        $response->assertContent('Forbidden');
        $response->assertStatus(403);
    }

    #[RunInSeparateProcess]
    public function test_basic_role_permissions()
    {
        $this->prepareDatabase();

        $user = User::find(self::BASIC_USER_ID);
        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertContent('home.index');
        $response->assertStatus(200);

        $response = $this->post('/home');
        $response->assertContent('Forbidden');
        $response->assertStatus(403);

        $response = $this->get('/home/create');
        $response->assertContent('Forbidden');
        $response->assertStatus(403);

        $response = $this->get('/home/id');
        $response->assertContent('home.show');
        $response->assertStatus(200);

        $response = $this->get('/home/id/edit');
        $response->assertContent('Forbidden');
        $response->assertStatus(403);

        $response = $this->put('home/id');
        $response->assertContent('Forbidden');
        $response->assertStatus(403);

        $response = $this->delete('home/id');
        $response->assertContent('Forbidden');
        $response->assertStatus(403);
    }
}
