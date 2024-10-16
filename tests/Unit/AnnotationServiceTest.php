<?php

namespace Uzzal\Acl\Tests\Unit;

use Illuminate\Support\Facades\Route;
use Uzzal\Acl\Services\AttributeService;
use Uzzal\Acl\Tests\TestCase;
use Workbench\App\Http\Controllers\HomeController;

class AnnotationServiceTest extends TestCase
{
    protected function defineRoutes($router)
    {
        $router->resource('home', HomeController::class);
    }

    public function test_hello()
    {
        $this->assertTrue(true);
    }

    public function testAnnotations()
    {
        $route = Route::getRoutes()->getByName('home.index');
        $action = $route->getAction();

        $service = new AttributeService();
        $service->setAction($action['controller']);

        $roles = $service->getRoleString();
        $resource = $service->getResourceName();

        $this->assertEquals('Admin, Basic', $roles);
        $this->assertEquals('Can see homepage.', $resource);
    }
}
