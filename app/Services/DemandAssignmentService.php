<?php

namespace App\Services;

use App\Mail\AssignDemandToUser;
use App\Models\PartnerDecision;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class DemandAssignmentService
{
    /**
     * Assign a demand of any type to a partner: record the assignment,
     * open an "awaiting" partner decision, and notify the partner by email.
     */
    public function assignToPartner(Model $demandable, User $partner): void
    {
        $demand = $demandable->demand;

        $demand->user_id = $partner->id;
        $demand->status = 'in progress';
        $demand->save();

        PartnerDecision::create([
            'demand_id' => $demand->id,
            'user_id' => $partner->id,
            'status' => 'awaiting',
            'comment' => null,
            'file' => null,
        ]);

        Mail::to($partner->email)->send(new AssignDemandToUser($partner, $demand));
    }
}
