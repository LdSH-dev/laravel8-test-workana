<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ForgotPasswordRequest;
use App\Http\Services\ForgotPasswordService;
use Illuminate\Support\Facades\Event;
use App\Events\PasswordResetRequested;

class ForgotPasswordController extends Controller {
    protected $forgotPasswordService;

    public function __construct(ForgotPasswordService $forgotPasswordService) {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function showLinkRequestForm() {
        return view('authentication.password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request) {
        $status = $this->forgotPasswordService->sendResetLink($request->only('email'));

        Event::dispatch(new PasswordResetRequested($request->email));

        return response()->json(['message' => 'Password reset link sent.']);
    }
}
