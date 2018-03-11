<?php
namespace Uzzal\Acl;

use Illuminate\Support\ServiceProvider;
use Blade;

class AclServiceProvider extends ServiceProvider {
    use ViewCompiler;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {                        
        if(!method_exists(Blade::getFacadeRoot(), 'nullsafe')){
            Blade::directive('nullsafe', function($expression) {
                return self::_nullsafeParser($expression);
            });
        }
        
        $this->loadViewsFrom(__DIR__ . '/views', 'acl');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__ . '/database/seeds/' => database_path('seeds')
                ], 'seeds');
        
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/acl'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/acl.php' => config_path('acl.php'),
        ], 'acl config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        include_once __DIR__ . '/routes.php';        
    }

}
