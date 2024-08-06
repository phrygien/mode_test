<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'pages.admin.dashboard')->name('dashboard');
Route::view('plan', 'pages.admin.plan.index')->name('plan');
