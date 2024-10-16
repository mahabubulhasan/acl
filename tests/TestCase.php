<?php

namespace Uzzal\Acl\Tests;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as WorkbenchTestCase;
use Workbench\Database\Seeders\DatabaseSeeder;
use function Orchestra\Testbench\artisan;

abstract class TestCase extends WorkbenchTestCase
{
    use RefreshDatabase;

    protected $loadEnvironmentVariables = false;

    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app['config'], function (Repository $config) {
            $config->set('database.default', 'testbench');
            $config->set('database.connections.testbench', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        });
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../workbench/database/migrations',
            __DIR__ . '/../src/database/migrations'
        ]);

        /*
        artisan($this, 'migrate', ['--database' => 'testbench']);
        $this->seed([
            DatabaseSeeder::class
        ]);*/

        /*
        $this->beforeApplicationDestroyed(
            fn() => artisan($this, 'migrate:rollback', ['--database' => 'testbench'])
        );*/
    }
}
