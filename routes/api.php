<?php

use App\Actions\Recipe\CreateNewRecipe;
use App\Actions\Recipe\DestroyRecipe;
use App\Actions\Recipe\GetAllRecipe;
use App\Actions\Recipe\GetOneRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/recipes')->group(function () {
    Route::get('/', GetAllRecipe::class);
    Route::get('/{recipe}', GetOneRecipe::class);
    Route::post('/', CreateNewRecipe::class);
    Route::patch('/{recipe}', CreateNewRecipe::class);
    Route::delete('/{id}', DestroyRecipe::class);
});
