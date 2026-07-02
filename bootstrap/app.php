<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/mjkn.php'));

            Route::middleware('web')
                ->group(base_path('routes/userrm.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cekloginrm' => \App\Http\Middleware\CekLoginRM::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();