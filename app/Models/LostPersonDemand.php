<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostPersonDemand extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',
        'date',
        'notification_sender',
        'missing_person_gender',
        'missing_person_age',
        'nationality',
        'location'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    protected $enumNotificationSenders = ['parent', 'friend', 'neighbor', 'other'];
    protected $enumGenders = ['female', 'male'];
    protected $enumAges = ['minor', 'adult'];

    public function demand()
    {
        return $this->morphOne(Demand::class, 'demandable');
    }

    public function setNotificationSenderAttribute($value)
    {
        $this->attributes['notification_sender'] = in_array($value, $this->enumNotificationSenders) ? $value : null;
    }

    public function setMissingPersonGenderAttribute($value)
    {
        $this->attributes['missing_person_gender'] = in_array($value, $this->enumGenders) ? $value : null;
    }

    public function setMissingPersonAgeAttribute($value)
    {
        $this->attributes['missing_person_age'] = in_array($value, $this->enumAges) ? $value : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($lostPersonDemand) {
            $lostPersonDemand->demand()->delete();
        });
    }
}

