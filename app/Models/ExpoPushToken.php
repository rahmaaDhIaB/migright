<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoPushToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'push_token',
        'device_id',
        'phone_number'
    ];
}
