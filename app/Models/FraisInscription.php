<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FraisInscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'code',
        'montant',
        'niveaux_id',
    ];

    public function cycle(): BelongsTo
    {
        return $this->belongsTo(Cycle::class, 'niveaux_id');
    }
}
