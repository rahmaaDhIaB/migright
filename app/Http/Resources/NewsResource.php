<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="NewsResource",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the news item"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         description="Title of the news item"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="Description of the news item"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string",
     *         description="Image URL of the news item"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'description' => $this->description ,
            'image' =>  asset('storage/uploads/images/'.$this->image),
        ];
    }
}
