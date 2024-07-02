<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class Register
{
    use AsAction, JsonResponseTrait;

    public function handle(string $name, string $username, string $email, string $password)
    {
        try {
            DB::beginTransaction();
            $user = User::create(compact('name', 'username', 'email', 'password'));

            DB::commit();
            return Auth::login($user);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
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
