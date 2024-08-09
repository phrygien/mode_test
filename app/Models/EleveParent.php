<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EleveParent extends Model
{
    use HasFactory;

    protected $fillable = [
        "eleve_id",
        "parent_id",
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(EleveParent::class);
    }

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }
}
