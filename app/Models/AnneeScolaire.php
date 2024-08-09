<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnneeScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'debut',
        'fin',
        'is_open'
    ];

    // has many inscrits
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    // has many affectation
    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class);
    }

    // has many emploi du tyemps
    public function emploidutemps(): HasMany
    {
        return $this->hasMany(Emploidutemp::class);
    }

    public function examens(): HasMany
    {
        return $this->hasMany(Examen::class);
    }

    public function trimestres(): HasMany
    {
        return $this->hasMany(Trimestre::class);
    }

    public function affectationMatiereNiveau(): HasMany
    {
        return $this->hasMany(AffectationMatiereNiveau::class);
    }
}
