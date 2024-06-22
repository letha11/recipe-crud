<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction, JsonResponseTrait;

    public function handle(string $name, string $username, string $email, string $password)
    {
        $user = User::create(compact('name', 'username', 'email', 'password'));

        return Auth::login($user);
    }

    public function asController(ActionRequest $request)
    {
        $token = $this->handle(
            $request->input('name'),
            $request->input('username'),
            $request->input('email'),
            $request->input('password')
        );

        return $this->success('Register Successful', ['token' => $token]);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string'],
        ];
    }
}
