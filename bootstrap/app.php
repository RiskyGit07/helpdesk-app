<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckProfileComplete;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckAdminProfileComplete;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'profile.complete' => CheckProfileComplete::class,
            'admin' => AdminMiddleware::class,
            'admin.profile.complete' => CheckAdminProfileComplete::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();