<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Demand;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignDemandToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $demand;
    public $demandType;

    public function __construct(User $user, Demand $demand)
    {
        $this->user = $user;
        $this->demand = $demand;
        switch ($demand->demandable_type) {
            case 'App\Models\AssistanceDemand':
                $this->demandType = 'Assistance';
                break;
            case 'App\Models\TestimonyDemand':
                $this->demandType = 'Testimony';
                break;
            case 'App\Models\LostPersonDemand':
                $this->demandType = 'Lost Person';
                break;
            default:
                $this->demandType = 'Unknown';
                break;
        }
    }

    public function build()
    {
        return $this->view('emails.assign_demand')
            ->subject('Nouvelle demande d\'aide affectée à votre attention')
            ->with([
                'user' => $this->user,
                'demand' => $this->demand,
            ]);
    }
}
