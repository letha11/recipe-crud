<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRecipe {
    use AsAction, JsonResponseTrait;

    public function handle(int $id): Builder|array|Collection|Model
    {
        return Recipe::with(['user','ratings'])->findOrFail($id);
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $recipe = new RecipeResource($this->handle($request->id));

            return $this->success(data: $recipe);
        } catch (ModelNotFoundException $e) {
            return $this->failed('Recipe not found', 404, $e->getMessage());
        } catch (\Exception $e) {
            logger($e);
            return $this->failed('Failed to get recipe', errors: $e->getMessage());
        }

    }
}
