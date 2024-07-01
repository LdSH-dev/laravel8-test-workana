<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Services\UserRegistrationService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller {
    protected $registrationService;

    public function __construct(UserRegistrationService $registrationService) {
        $this->registrationService = $registrationService;
    }

    public function showRegistrationForm() {
        return view('authentication.register');
    }

    public function register(RegisterRequest $request): JsonResponse {
        $user = $this->registrationService->register($request->all());

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }
}
