<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
// gestion frais
Route::view('inscriptions', 'pages.tenants.frais.inscriptions.index')->name('inscriptions');
Route::view('inscriptions/create', 'pages.tenants.frais.inscriptions.create')->name('inscriptions.create');