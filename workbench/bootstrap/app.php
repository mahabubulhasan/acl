<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Uzzal\Acl\Commands\AclResource;
use Uzzal\Acl\Middleware\AuthenticateWithAcl;
use function Orchestra\Testbench\default_skeleton_path;

return Application::configure(basePath: $APP_BASE_PATH ?? default_skeleton_path())
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['auth.acl' => AuthenticateWithAcl::class]);
    })
    ->withCommands([
        AclResource::class
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
