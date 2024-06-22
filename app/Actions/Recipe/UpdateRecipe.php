<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRecipe
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id, array $data)
    {
        // FIXME
        // Auth and other stuff
        $recipe = Recipe::findOrFail($id);

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
        } catch (\Throwable $e) {
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
