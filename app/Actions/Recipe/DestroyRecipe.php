<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class DestroyRecipe
{
    use AsAction;

    public function handle(int $id): void
    {
            $recipe = Recipe::findOrFail($id);
            $recipe->deleteOrFail();
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $this->handle($request->id);

            $status = 204;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("Recipe not found", 404);
        } catch (Throwable $e) {
            logger($e);
            throw new HttpException("Failed to delete recipe", 500);
        }

        return response()->json(null, $status);
    }
}
