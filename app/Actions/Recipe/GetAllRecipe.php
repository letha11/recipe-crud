<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeCollection;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllRecipe
{
    use AsAction;

    public function handle(Request $request): JsonResponse
    {
        $recipes = Recipe::with('user')->get();

        return response()->json([
            'error' => false,
            'data' => new RecipeCollection($recipes),
        ]);
    }
}
