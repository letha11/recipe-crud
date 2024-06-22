<?php

namespace App\Actions\User;

use Lorisleiva\Actions\Concerns\AsAction;

class GetOneUser
{
    use AsAction;

    public function handle(User $user)
    {
        $response = $user->toArray();
        $response['error'] = false;

        return response()->json($response);
    }
}
