<?php

namespace App\Actions\Auth;

use App\Traits\JsonResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Login
{
    use AsAction, JsonResponseTrait;

    public function handle(string $username, string $password)
    {
        $credentials = ['username' => $username, 'password' => $password];

        return auth()->attempt($credentials);
    }

    public function asController(ActionRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (!$token = $this->handle($username, $password)) {
            return $this->failed('Invalid Credentials', Response::HTTP_UNAUTHORIZED);
        }

        $response_data = [
            'token' => $token,
        ];

        return $this->success('Login Success', $response_data);
    }

    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
