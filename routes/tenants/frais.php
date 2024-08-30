<?php

declare(strict_types=1);

use App\Models\FraisAdmission;
use App\Models\FraisInscription;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\Route;
// gestion frais
Route::view('inscriptions', 'pages.tenants.frais.inscriptions.index')->name('inscriptions');
Route::view('inscriptions/create', 'pages.tenants.frais.inscriptions.create')->name('inscriptions.create');
Route::get('inscriptions/{id}/edit', function (FraisInscription $fraisInscription, $id) {
    $fraisInscription = FraisInscription::find($id);
    return view('pages.tenants.frais.inscriptions.edit', compact('fraisInscription'));
})->name('fraisinscriptions.edit');

// pour les frais d'admissions
Route::view('admissions', 'pages.tenants.frais.admissions.index')->name('admissions');
Route::view('admissions/create', 'pages.tenants.frais.admissions.create')->name('admissions.create');
Route::get('admissions/{id}/edit', function (FraisAdmission $fraisAdmission, $id) {
    $fraisAdmission = FraisAdmission::find($id);
    return view('pages.tenants.frais.admissions.edit', compact('fraisAdmission'));
})->name('fraisadmissions.edit');