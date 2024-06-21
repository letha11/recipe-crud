<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetOneRecipe {
    use AsAction;

    public function handle(Recipe $recipe, Request $request): JsonResponse
    {
        $recipe = $recipe->load('user', 'ratings');

        return response()->json([
            'error' => false,
            'data' => new RecipeResource($recipe),
        ]);
    }
}
