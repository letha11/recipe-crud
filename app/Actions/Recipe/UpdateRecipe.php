<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateRecipe
{
    use AsAction;

    public function handle(Recipe $recipe, Request $request)
    {
        $recipe->update($request->all());

        return $recipe;
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
