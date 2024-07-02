<?php

use App\Actions\Auth\GetAuthenticatedUser;
use App\Actions\Auth\Login;
use App\Actions\Auth\Register;
use App\Actions\Auth\SendEmailVerification;
use App\Actions\Auth\VerifyEmail;
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
//    Route::post('/', CreateUser::class);
//    Route::patch('/{id}', UpdateUser::class);
});


Route::prefix('auth')->group(function () {
    Route::post('/login', Login::class)->name('login');
    Route::post('/register', Register::class);
    Route::get('/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');
    Route::get('/user', GetAuthenticatedUser::class)->middleware('auth');
    Route::post('/verify/resend', SendEmailVerification::class)->middleware('auth');
});

Route::prefix('/recipes')->group(function () {
    Route::get('/', GetAllRecipe::class);
    Route::get('/{id}', GetRecipe::class);
    Route::middleware('auth')->group(function () {
        Route::post('/', CreateNewRecipe::class);
        Route::patch('/{id}', UpdateRecipe::class);
        Route::delete('/{id}', DestroyRecipe::class);
        Route::post('/{id}/rating', AddRating::class);
    });
});
