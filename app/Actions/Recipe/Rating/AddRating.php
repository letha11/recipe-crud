<?php

namespace App\Actions\Recipe\Rating;

use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class AddRating
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id, int $rating)
    {
        $recipe = Recipe::findOrFail($id);

        $recipe->ratings()->create([
            'user_id' => $recipe->user_id, // FIXME This should be the authenticated user
            'rating' => $rating,
        ]);
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $this->handle($request->id, $request->input('rating'));

            return $this->success('Rating added successfully');
        } catch (\Exception $e) {
             logger($e);
            return $this->failed('Failed to add recipe', errors: $e->getMessage());
        }
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }
}
