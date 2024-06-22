<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllRecipe
{
    use AsAction;

    public function handle(): array
    {
        $recipes = Recipe::with('user')->paginate(10)->toArray();

        return $recipes;
    }

    public function asController(Request $request): JsonResponse
    {
        $recipes = $this->handle();
        $recipes['error'] = false;

        return response()->json($recipes);
    }
}
