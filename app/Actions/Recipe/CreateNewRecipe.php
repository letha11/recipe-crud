<?php

namespace App\Actions\Recipe;

use App\Http\Resources\RecipeResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewRecipe
{
    use AsAction, JsonResponseTrait;

    public function handle(String $title, String $description, String $ingredients, String $instructions, Int $prep_time)
    {
        $user = User::findOrFail(1);
        return $user->recipes()->create(
            compact('title', 'description', 'ingredients', 'instructions', 'prep_time')
        );
    }

    public function asController(ActionRequest $request): JsonResponse
    {
        try {
            $recipe = $this->handle(
                $request->input('title'),
                $request->input('description'),
                $request->input('ingredients'),
                $request->input('instructions'),
                $request->input('prep_time')
            );

            return $this->success('Recipe created successfully', new RecipeResource($recipe), 201);
        } catch (\Exception $e) {
            logger($e);
            return $this->failed('Failed to create recipe', errors: $e->getMessage());
        }
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
