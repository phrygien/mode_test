<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class,])->group(static function (): void {
    Route::middleware(['guest'])->prefix('auth')->as('auth:')->group(static function (): void {
        Route::view('login', 'pages.auth.login')->name('login');
    });

    Route::middleware(['auth'])->group(static function (): void {
        Route::view('/', 'pages.tenants.index')->name('home');
        Route::prefix('settings')->as('settings:')->group(
            base_path(
                path: 'routes/tenants/settings.php',
            )
        );

        // Routes for configuration modules
        Route::prefix('configurations')->as('configurations:')->group(
            base_path(
                path: 'routes/tenants/configurations.php',
            )
        );

        // for managing academy fee
        Route::prefix('frais')->as('frais:')->group(
            base_path(
                path: 'routes/tenants/frais.php',
            )
        );

        // for managing academy settings
        Route::prefix('academy')->as('academy:')->group(
            base_path(
                path: 'routes/tenants/academy.php',
            )
        );

    });
});
