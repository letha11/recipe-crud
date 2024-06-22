<?php

use App\Actions\Recipe\CreateNewRecipe;
use App\Actions\Recipe\DestroyRecipe;
use App\Actions\Recipe\GetAllRecipe;
use App\Actions\Recipe\GetRecipe;
use App\Actions\Recipe\Rating\AddRating;
use App\Actions\Recipe\UpdateRecipe;
use App\Actions\User\CreateUser;
use App\Actions\User\GetAllUser;
use App\Actions\User\GetUser;
use App\Actions\User\UpdateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/users')->group(function () {
    Route::get('/', GetAllUser::class);
    Route::get('/{id}', GetUser::class);
    Route::post('/', CreateUser::class);
    Route::patch('/{id}', UpdateUser::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/recipes')->group(function () {
    Route::get('/', GetAllRecipe::class);
    Route::get('/{id}', GetRecipe::class);
    Route::post('/', CreateNewRecipe::class);
    Route::patch('/{id}', UpdateRecipe::class);
    Route::delete('/{id}', DestroyRecipe::class);
    Route::post('/{id}/rating', AddRating::class);
});
