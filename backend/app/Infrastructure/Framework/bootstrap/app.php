<?php

use App\Infrastructure\Framework\Application;
use App\Infrastructure\Framework\Providers\EventsLogServiceProvider;
use App\Infrastructure\Framework\Providers\UserServiceProvider;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        UserServiceProvider::class,
        EventsLogServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__ . '/../../../Presentation/RestApi/routes.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

//$app->loadEnvironmentFrom(__DIR__ . "/../../../../.env");

return $app;
