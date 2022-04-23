<?php

namespace Uzzal\Acl;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Uzzal\Acl\Commands\AclResource;
use Uzzal\Acl\Services\AnnotationService;
use Uzzal\Acl\Services\AttributableInterface;
use Uzzal\Acl\Services\AttributeService;


class AclServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::if('let', function ($resource) {
            return \Uzzal\Acl\Services\PermissionCheckService::hasAccess($resource);
        });

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        if($this->app->runningInConsole()){
            $this->commands([
                AclResource::class
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton(AttributableInterface::class, AttributeService::class);
    }

}
