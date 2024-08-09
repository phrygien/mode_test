<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'situation_familiale',
        'cin',
        'adresse',
        'telephone',
        'email',
        'imatricule',
        'photo',
    ];

    // has many parents
    public function parentEleves(): HasMany
    {
        return $this->hasMany(ParentEleve::class);
    }

    // has many documents
    public function documents(): HasMany
    {
        return $this->hasMany(DocumentEleve::class);
    }
}
