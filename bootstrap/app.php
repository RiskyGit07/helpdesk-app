<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserProfileComplete;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckAdminProfileComplete;
use App\Http\Middleware\MainAdminMiddleware; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'main.admin' => MainAdminMiddleware::class,
            'profile.complete' => CheckUserProfileComplete::class,
            'admin.profile.complete' => CheckAdminProfileComplete::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();