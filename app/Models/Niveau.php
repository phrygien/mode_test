<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Niveau extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "abreviation",
        "cycle_id"
    ];

    public function cycles(): HasMany
    {
        return $this->hasMany(Cycle::class);
    }
}
