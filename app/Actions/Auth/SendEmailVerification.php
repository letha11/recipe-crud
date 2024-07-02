<?php

namespace App\Actions\Auth;

use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SendEmailVerification
{
    use AsAction, JsonResponseTrait;

    public function handle()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return false;
        }

        Auth::user()->sendEmailVerificationNotification();

        return true;
    }

    public function asController(ActionRequest $request)
    {
        $result = $this->handle();

        return $this->success($result ? 'Email Verification sent' : 'Email already verified');
    }
}
