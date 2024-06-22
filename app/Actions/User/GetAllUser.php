<?php

namespace App\Actions\User;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAllUser
{
    use AsAction, JsonResponseTrait;

    public function handle()
    {
        return User::paginate(10)->toArray();
    }

    public function asController(Request $request)
    {
        $users = $this->handle();

        return $this->successPaginate('Successfully retrieve users', $users);
    }

}
