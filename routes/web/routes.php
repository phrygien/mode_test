<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->as('pages:')->group(static function (): void {
        Route::view('/', 'pages.index')->name('home');
        Route::middleware(['auth'])->group(static function (): void {
            Route::view('/accueil', 'pages.accueil')->name('dashboard');
            Route::view('/setup', 'pages.setup.setup')->name('setup');
            Route::view('/my-setup', 'pages.setup.mon-setup')->name('my-setup');
        });

        Route::prefix('auth')->as('auth:')->group(static function (): void {
            Route::view('register', 'pages.auth.register')->name('register');
            Route::view('login', 'pages.auth.login-client')->name('login');
            Route::view('admin-login', 'pages.auth.login-admin')->name('admin-login');
        });

        // admin routes
        Route::middleware(['auth'])->group(static function (): void {
            Route::prefix('admin')->as('admin:')->group(
                base_path(
                    path: 'routes/web/admin.php',
                )
            );
        });

    });
}
