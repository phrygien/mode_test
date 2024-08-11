<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trimestre extends Model
{
    use HasFactory;

    public function anneescolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
}
