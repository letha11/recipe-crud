<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class DestroyRecipe
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id): void
    {
        $user = Auth::user();
        $recipe = Recipe::findOrFail($id);

        if ($user->id !== $recipe->user_id) {
            throw new AuthenticationException(); // FIXME
        }

        $recipe->deleteOrFail();
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $this->handle($request->id);

            return $this->success(status_code: 204);
        } catch (ModelNotFoundException $e) {
            return $this->failed('Recipe not found', 404, $e->getMessage());
        } catch (Throwable $e) {
            logger($e);
            return $this->failed('Failed to delete recipe', errors: $e->getMessage());
        }
    }
}
