<?php

namespace Uzzal\Acl\Tests;

use Illuminate\Contracts\Config\Repository;
use Orchestra\Testbench\TestCase as WorkbenchTestCase;
use Uzzal\Acl\AclServiceProvider;
use function Orchestra\Testbench\workbench_path;

abstract class TestCase extends WorkbenchTestCase
{
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
        $this->loadMigrationsFrom(workbench_path('database/migrations'));
    }

    protected function getPackageProviders($app)
    {
        return [
            AclServiceProvider::class
        ];
    }
}
