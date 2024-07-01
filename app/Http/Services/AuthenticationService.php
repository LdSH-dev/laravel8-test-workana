<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticationService {

    /**
     * Handle user login.
     *
     * @param array $credentials
     * @return JsonResponse
     */
    public function login(array $credentials): JsonResponse {
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['access_token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Handle user logout.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }

        Auth::guard('web')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
