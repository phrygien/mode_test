<?php

declare(strict_types=1);

use App\Models\AnneeScolaire;
use App\Models\Niveau;
use App\Models\Section;
use Illuminate\Support\Facades\Route;

/**
 * admissions routes
 */
Route::view('admissions', 'pages.tenants.academy.admission.index')->name('admissions');
Route::view('admissions/create', 'pages.tenants.academy.admission.create')->name('admissions.create');