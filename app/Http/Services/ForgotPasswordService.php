<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Password;

class ForgotPasswordService {
    /**
     * Handle sending the reset password link.
     *
     * @param array $credentials
     * @return string
     */
    public function sendResetLink(array $credentials) {
        return Password::sendResetLink($credentials);
    }
}
