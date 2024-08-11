<?php

declare(strict_types=1);

use App\Models\AnneeScolaire;
use App\Models\Niveau;
use App\Models\Section;
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

// gestion niveau
Route::view('niveaux', 'pages.tenants.niveauxs.index')->name('niveaux');
Route::view('niveaux/create', 'pages.tenants.niveauxs.create')->name('niveaux.create');
Route::get('niveaux/{id}/edit', function (Niveau $niveau, $id) {
    $niveau = Niveau::find($id);
    return view('pages.tenants.niveauxs.edit', compact('niveau'));
})->name('niveaux.edit');

// gestion section
Route::view('sections', 'pages.tenants.sections.index')->name('sections');
Route::view('sections/create', 'pages.tenants.sections.create')->name('sections.create');
Route::get('sections/{id}/edit', function (Section $section, $id) {
    $section = Section::find($id);
    return view('pages.tenants.sections.edit', compact('section'));
})->name('sections.edit');

// gestion trimestre
Route::view('trimestres', 'pages.tenants.trimestres.index')->name('trimestres');
Route::view('trimestres/create', 'pages.tenants.trimestres.create')->name('trimestres.create');