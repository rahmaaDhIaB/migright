<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="DemandResource",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="firstName",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="lastName",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="status",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="details",
     *         type="object",
     *         additionalProperties=true
     *     ),
     *      @OA\Property(
     *          property="type",
     *          type="string",
     *      )
     * )
     */

    public function toArray(Request $request): array
    {
        switch ($this->demandable_type) {
            case 'App\Models\LostPersonDemand' :
                $type = 'Lost Person Demand';
                break;
            case 'App\Models\AssistanceDemand' :
                $type = 'Assistance Demand';
                break;
            default :
                $type = 'Testimony Demand';
                break;
        }
        return [
            'id' => $this->id,
            'title' => 'title',
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'description' => $this->description,
            'phone' => $this->phone_number,
            'email' => $this->email,
            'status' => $this->status,
            'details' => $this->demandable ?? [],
            'file' => asset('storage/uploads/demands/' . $this->file),
            'type' => $type,
            'message' => $this->admin_comment ,
            'decisionFile' => asset('storage/uploads/demands/' . $this->partner_decision_file) ,
        ];
    }
}
