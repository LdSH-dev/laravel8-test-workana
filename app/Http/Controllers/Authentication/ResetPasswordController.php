<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ResetPasswordRequest;
use App\Http\Services\PasswordResetService;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller {
    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService) {
        $this->passwordResetService = $passwordResetService;
    }

    public function showResetForm(Request $request, $token = null) {
        return view('authentication.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(ResetPasswordRequest $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = $this->passwordResetService->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect('/')->with('status', 'Password reset successfully.');
        } else {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Password reset failed.']);
        }
    }
}
