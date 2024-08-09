<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inscription extends Model
{
    use HasFactory;

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(PaiementInscription::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(DocumentInscription::class);
    }
}
