<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllUser
{
    use AsAction;

    public function handle()
    {
        return User::paginate(10);
    }

    public function asController(Request $request)
    {
        $users = $this->handle();

        $response = $users->toArray();
        $response['error'] = false;

        return response()->json($response);
    }

}
