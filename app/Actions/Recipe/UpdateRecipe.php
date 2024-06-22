<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRecipe
{
    use AsAction;

    public function handle(int $id, array $data)
    {
        // FIXME
        // Auth and other stuff
        $recipe = Recipe::findOrFail($id);

        return $recipe->updateOrFail($data);
    }

    public function asController(Request $request): JsonResponse
    {
        $recipe = $this->handle(
            $request->id,
            $request->all(),
        );

        return response()->json([
            'error' => false,
            'message' => 'Recipe updated successfully',
        ]);
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
