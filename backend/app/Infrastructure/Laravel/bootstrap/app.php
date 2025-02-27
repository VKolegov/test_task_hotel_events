<?php

use App\Infrastructure\Laravel\Application;
use App\Infrastructure\Laravel\Providers\AuthServiceProvider;
use App\Infrastructure\Laravel\Providers\EventsLogServiceProvider;
use App\Infrastructure\Laravel\Providers\UserServiceProvider;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        UserServiceProvider::class,
        EventsLogServiceProvider::class,
        AuthServiceProvider::class,
    ])
    ->withRouting(
        api: __DIR__ . '/../../../Presentation/RestApi/routes.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            HandleCors::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

//$app->loadEnvironmentFrom(__DIR__ . "/../../../../.env");

return $app;
