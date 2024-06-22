<?php

namespace App\Actions\User;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUser
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id): Model|Collection|Builder|array|null
    {
        return User::with('recipes')->findOrFail($id);
    }

    public function asController(Request $request): JsonResponse
    {
        try{
            $user = $this->handle($request->id);

            return $this->success(data: new UserResource($user));
        } catch (ModelNotFoundException $e) {
            return $this->failed('User not found', 404, $e->getMessage());
        } catch (\Exception $e) {
            logger($e);
            return $this->failed('Failed to get user', errors: $e->getMessage());
        }
    }
}
