<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rating' => $this->rating,
            'name' => $this->when($this->relationLoaded('user'), fn () => $this->user->name),
//            'user' => new UserResource($this->whenLoaded('user')),
            'recipe' => new RecipeResource($this->whenLoaded('recipe')),
        ];
    }
}
