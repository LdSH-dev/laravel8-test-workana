<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller {
    protected $authService;

    public function __construct(AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse {
        return $this->authService->login($request->only('email', 'password'));
    }

    public function logout(): JsonResponse {
        return $this->authService->logout();
    }

    public function showForm() {
        return view('authentication.login');
    }
}
