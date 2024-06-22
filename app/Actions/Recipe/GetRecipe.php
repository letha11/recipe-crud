<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRecipe {
    use AsAction;

    public function handle(int $id): Builder|array|Collection|Model
    {
        return Recipe::with(['user','ratings'])->findOrFail($id);
    }

    public function asController(Request $request): JsonResponse
    {
        $recipe = $this->handle($request->id);

        return response()->json([
            'error' => false,
            'data' => new RecipeResource($recipe),
        ]);
    }
}
