<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Password;

class PasswordResetService {
    /**
     * Handle the reset password logic.
     *
     * @param array $credentials
     * @param \Closure $callback
     * @return string
     */
    public function reset(array $credentials, \Closure $callback) {
        return Password::reset($credentials, $callback);
    }
}
