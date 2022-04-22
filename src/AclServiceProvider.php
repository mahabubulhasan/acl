<?php

namespace Uzzal\Acl;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class AclServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::if('let', function ($resource) {
            return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
        });

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function register()
    {

    }

}
