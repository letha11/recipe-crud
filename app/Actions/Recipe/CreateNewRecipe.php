<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewRecipe
{
    use AsAction;

    public function handle(Request $request): JsonResponse
    {
        // FIXME
        $user = User::find(1);
        $recipe = $user->recipes()->create($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Recipe created successfully',
            'recipe' => new RecipeResource($recipe),
        ], 201);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'instructions' => ['required', 'string'],
            'prep_time' => ['required', 'integer'],
        ];
    }
}
