<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class DestroyRecipe
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id): void
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->deleteOrFail();
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $this->handle($request->id);
        } catch (ModelNotFoundException $e) {
            return $this->failed('Recipe not found', 404, $e->getMessage());
        } catch (Throwable $e) {
            logger($e);
            return $this->failed('Failed to delete recipe', errors: $e->getMessage());
        }

        return $this->success(status_code: 204);
    }
}
