<?php

declare(strict_types=1);

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CheckPermission;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/routes.php',
        commands: __DIR__ . '/../routes/console/routes.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => AuthMiddleware::class,
            'permission' => CheckPermission::class
        ]);
        $middleware->group('universal', []);
    })
    ->withExceptions(function (Exceptions $exceptions): void { })->create();
