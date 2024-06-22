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

    public function handle(String $title, String $description, String $ingredients, String $instructions, Int $prep_time)
    {
        $user = User::findOrFail(1);
        return $user->recipes()->create(
            compact('title', 'description', 'ingredients', 'instructions', 'prep_time')
        );
    }

    public function asController(Request $request): JsonResponse
    {
        $recipe = $this->handle(
            $request->input('title'),
            $request->input('description'),
            $request->input('ingredients'),
            $request->input('instructions'),
            $request->input('prep_time')
        );

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
