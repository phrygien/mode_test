<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FraisAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'user_id',
        'cycle_id',
        'annee_scolaire_id',
        'montant'
    ];

    public function anneescolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }

    // has one cycle
    public function cycle(): BelongsTo
    {
        return $this->belongsTo(Cycle::class);
    }
}
