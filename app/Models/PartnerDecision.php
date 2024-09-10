<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerDecision extends Model
{
    use HasFactory;

    // Specify the table if it's different from the default naming convention
    protected $table = 'partner_decision';

    // Define which attributes can be mass-assigned
    protected $fillable = [
        'demand_id',
        'user_id',
        'status',
        'comment',
        'file'
    ];

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
}

