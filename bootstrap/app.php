<?php

use App\Http\Middleware\IsAdminLoggedIn;
use App\Http\Middleware\isCashierLoggedIn;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Roles;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'IsAdminLoggedIn' => IsAdminLoggedIn::class,
            'IsCashierLoggedIn' => isCashierLoggedIn::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
