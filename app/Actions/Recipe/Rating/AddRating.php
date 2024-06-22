<?php

namespace App\Actions\Recipe\Rating;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class AddRating
{
    use AsAction;

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
        $this->handle($request->id, $request->input('rating'));

        return response()->json([
            'error' => false,
            'message' => 'Rating added successfully',
        ]);
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ];
    }
}
