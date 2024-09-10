<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CancellationReason extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function demands(): HasMany
    {
        return $this->hasMany(Demand::class);
    }
}
