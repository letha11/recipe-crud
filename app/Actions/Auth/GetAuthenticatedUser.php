<?php

namespace App\Actions\Auth;

use App\Traits\JsonResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class GetAuthenticatedUser
{
    use AsAction, JsonResponseTrait;

    public function handle()
    {
        return Auth::user();
    }

    public function asController(ActionRequest $request)
    {
        $user = $this->handle();

        return $this->success(data: $user);
    }
}
