<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        // Mitigate session fixation when authenticating via the web guard
        $request->session()->regenerate();

        /** @var User $user */
        $user = User::where('email', $credentials['email'])->firstOrFail();

        $tokenName = $request->userAgent() ?: 'api';
        $token = $user->createToken($tokenName)->plainTextToken;

        // Do not expose password; model already hides sensitive fields
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    // POST /api/register
    public function register(Request $request, CreateNewUser $creator)
    {
        // Leverage Fortify's CreateNewUser for validation + creation
        /** @var User $user */
        $user = $creator->create($request->all());

        $tokenName = $request->userAgent() ?: 'api';
        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }
}
