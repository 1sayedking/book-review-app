<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAdmin;// to support middleware add this

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            // 'check-admin'-->copy this as middleware name apply in route
            'check-admin'=>CheckAdmin::class
        ]);

        $middleware->redirectTo(
            guests:'account/login',
            users:'account/profile'
        );
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
