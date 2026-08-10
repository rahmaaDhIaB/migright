<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Demand extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone_number', 'file', 'description', 'status' , 'partner_decision_file', 'admin_comment','cancellation_reason_id'
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    protected $enumStatuses = ['pending', 'in progress', 'done', 'refused', 'cancelled'];

    public function demandable()
    {
        return $this->morphTo();
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = in_array($value, $this->enumStatuses) ? $value : 'pending';
    }

    public function types() : BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    public function cancellationReason() : BelongsTo
    {
        return $this->belongsTo(CancellationReason::class, 'cancellation_reason_id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'partner_decision')
            ->withPivot('status', 'comment', 'file')
            ->withTimestamps();
    }


}
