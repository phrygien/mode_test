<?php

declare(strict_types=1);

use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\Route;

Route::view('annees', 'pages.tenants.annees.index')->name('annees');
Route::view('annees/create', 'pages.tenants.annees.create')->name('annees.create');
Route::get('annees/{id}/edit', function (AnneeScolaire $anneescolaire, $id) {
    $anneescolaire = AnneeScolaire::find($id);
    return view('pages.tenants.annees.edit', compact('anneescolaire'));
})->name('annees.edit');

// gestion cycle
Route::view('cycles', 'pages.tenants.cycles.index')->name('cycles');
Route::view('cycles/create', 'pages.tenants.cycles.create')->name('cycles.create');