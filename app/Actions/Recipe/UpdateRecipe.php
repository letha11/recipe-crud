<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRecipe
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id, array $data)
    {
        $user = Auth::user();
        $recipe = Recipe::findOrFail($id);

        if ($user->id !== $recipe->user_id) {
            throw new AuthenticationException(); // FIXME
        }

        return $recipe->updateOrFail($data);
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $recipe = $this->handle(
                $request->id,
                $request->all(),
            );

            return $this->success('Recipe updated successfully');
        } catch (\Exception $e) {
            logger($e);
            return $this->failed('Failed to update recipe', errors: $e->getMessage());
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'ingredients' => ['sometimes', 'string'],
            'instructions' => ['sometimes', 'string'],
            'prep_time' => ['sometimes', 'integer'],
        ];
    }

}
