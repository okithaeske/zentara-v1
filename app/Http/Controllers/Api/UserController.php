<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        if (!$currentUser?->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $users = User::query()
            ->orderByDesc('id')
            ->get()
            ->makeHidden(['profile_photo_path']);

        return response()->json(['data' => $users]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $currentUser = $request->user();
        if (!$currentUser) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($currentUser->getKey() !== $user->getKey() && !$currentUser->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $rules = [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email:rfc,dns', 'max:255', Rule::unique('users')->ignore($user->getKey())],
            'password' => ['sometimes', 'string', 'min:8'],
        ];

        if ($currentUser->isAdmin()) {
            $rules['role'] = ['sometimes', 'string', Rule::in(['admin', 'seller', 'user'])];
            $rules['banned'] = ['sometimes', 'boolean'];
        }

        $data = $request->validate($rules);

        if (array_key_exists('password', $data)) {
            $user->setAttribute('password', Hash::make($data['password']));
            unset($data['password']);
        }
        if (array_key_exists('banned', $data)) {
            $user->setAttribute('banned', $data['banned']);
            unset($data['banned']);
        }

        $user->fill($data);
        $user->save();

        $user->refresh()->makeHidden(['profile_photo_path']);

        return response()->json(['data' => $user]);
    }
}
