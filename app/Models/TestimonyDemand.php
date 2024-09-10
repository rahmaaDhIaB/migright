<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonyDemand extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    protected $attributes = [
        'type' => 'anonymous',
    ];

    protected $enumTypes = ['anonymous', 'identified'];

    public function demand()
    {
        return $this->morphOne(Demand::class, 'demandable');
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = in_array($value, $this->enumTypes) ? $value : 'anonymous';
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($testimonyDemand) {
            $testimonyDemand->demand()->delete();
        });
    }

    public function cancellationReason()
    {
        return $this->belongsTo(CancellationReason::class);
    }
}

