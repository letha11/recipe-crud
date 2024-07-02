<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Response;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyEmail
{
    use AsAction, JsonResponseTrait;

    public function handle(int $userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return true;
    }

    public function asController(int $userId, ActionRequest $request)
    {
        if (!$request->hasValidSignature()) {
            return $this->failed('Invalid/Expired url provided', Response::HTTP_UNAUTHORIZED);
        }

        $result = $this->handle($userId);

        if (!$result) {
            return $this->failed('Something went wrong, please try again.');
        }

        return $this->success('Email has been verified');
    }
}
