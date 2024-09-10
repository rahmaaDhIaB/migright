<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceDemand extends Model
{
    use HasFactory;

    protected $fillable = ['region', 'requestSubmitter'];

    protected $enumRequestSubmitters = ['concernedPerson', 'otherPerson'];

    public function demand()
    {
        return $this->morphOne(Demand::class, 'demandable');
    }

    public function setRequestSubmitterAttribute($value)
    {
        $this->attributes['requestSubmitter'] = in_array($value, $this->enumRequestSubmitters) ? $value : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($assistanceDemand) {
            $assistanceDemand->demand()->delete();
        });
    }
}
