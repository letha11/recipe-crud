<?php

namespace App\Actions\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction, JsonResponseTrait;

    public function handle(String $name, String $username, String $email, String $password)
    {
        return User::create(compact('name', 'username', 'email', 'password'));
    }

    public function asController(Request $request): JsonResponse
    {
        $user = $this->handle(
            $request->input('name'),
            $request->input('username'),
            $request->input('email'),
            $request->input('password')
        );

        return $this->success('User created successfully', new UserResource($user), 201);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
