<?php

namespace Uzzal\Acl;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__.'/views','acl');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        
        $this->publishes([
        __DIR__.'/database/seeds/' => database_path('seeds')
        ], 'seeds');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include_once __DIR__.'/routes.php';
        $this->app->make('Uzzal\Acl\TestController');
    }

}
