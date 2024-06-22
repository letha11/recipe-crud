<?php

namespace App\Actions\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    public function handle(String $name, String $email, String $password)
    {
        return User::create(compact('name', 'email', 'password'));
    }

    public function asController(Request $request): JsonResponse
    {
        $user = $this->handle(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json([
            'error' => false,
            'message' => 'User created successfully',
            'data' => new UserResource($user),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
