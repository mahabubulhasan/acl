<?php

namespace Uzzal\Acl;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Uzzal\Acl\Commands\AclResource;
use Uzzal\Acl\Services\AttributableInterface;
use Uzzal\Acl\Services\AttributeService;


class AclServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::if('allowed', function ($resource) {
            return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
        });

        $this->loadViewsFrom(__DIR__ . '/views', 'acl');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        if($this->app->runningInConsole()){
            $this->commands([
                AclResource::class
            ]);
        }

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/acl'),
        ], 'acl-views');
    }

    public function register()
    {
        $this->app->singleton(AttributableInterface::class, AttributeService::class);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

}
