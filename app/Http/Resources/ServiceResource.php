<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="ServiceResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Service Name"),
     *     @OA\Property(property="description", type="string", example="Service Description"),
     *     @OA\Property(property="address", type="string", example="Service Address"),
     *     @OA\Property(property="category", ref="#/components/schemas/CategoryResource"),
     *     @OA\Property(property="region", ref="#/components/schemas/RegionResource"),
     *     @OA\Property(property="contact", type="string", example="Contact Information"),
     *     @OA\Property(property="location_url", type="string", format="url", example="https://example.com/location"),
     *     @OA\Property(property="image", type="string", format="url", example="https://example.com/storage/uploads/images/service.jpg")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'description' => $this->description ,
            'address' => $this->address ,
            'category' => CategoryResource::make($this->category) ,
            'region' => RegionResource::make($this->region),
            'contact' => $this->contact ,
            'location_url' => $this->location_url ,
            'image' => asset('storage/uploads/images/'.$this->image),
        ];
    }
}
