<?php

namespace App\Actions\Recipe;

use App\Models\Recipe;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllRecipe
{
    use AsAction, JsonResponseTrait;

    public function handle(): array
    {
        $recipes = Recipe::with('user')->paginate(10)->toArray();

        return $recipes;
    }

    public function asController(Request $request): JsonResponse
    {
        $recipes = $this->handle();

        return $this->successPaginate('Successfully retrieved all Recipe', $recipes);
    }
}
