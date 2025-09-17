<?php

use App\Http\Middleware\AllowAdmin;
use App\Http\Middleware\AllowClient;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));

            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/client.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your custom middleware aliases here
        $middleware->alias([
            'admin' => AllowAdmin::class,
            'client' => AllowClient::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
