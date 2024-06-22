<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'prep_time' => $this->prep_time,
            'author' => new UserResource($this->user),
            'ratings' => $this->when($this->relationLoaded('ratings'), function () {
                return RatingResource::collection($this->ratings->load('user'));
            }),
            'average_rating' => $this->ratings->avg('rating'),
            'created_at' => $this->created_at,
        ];
    }
}
