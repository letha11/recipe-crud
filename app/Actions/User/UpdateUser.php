<?php

namespace App\Actions\User;

use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUser
{
    use AsAction, JsonResponseTrait;

    public function handle(int $id, array $data): bool
    {
        $user = User::findOrFail($id);
        return $user->update($data);
    }

    public function asController(int $id, Request $request): JsonResponse
    {
        try {
            $this->handle($id, $request->all());

            return $this->success('User updated successfully');
        } catch(\Exception $e) {
            logger($e);
            return $this->failed('Failed to update user', errors: $e->getMessage());
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email'],
            'password' => ['sometimes', 'string'],
        ];
    }
}
