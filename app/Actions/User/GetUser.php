<?php

namespace App\Actions\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUser
{
    use AsAction;

    public function handle(int $id): Model|Collection|Builder|array|null
    {
        return User::with('recipes')->findOrFail($id);
    }

    public function asController(Request $request): JsonResponse
    {
        $user = $this->handle($request->id);

        return response()->json([
            'error' => false,
            'data' => new UserResource($user),
        ]);
    }
}
