<?php

namespace App\Listeners;

use App\Events\PasswordResetRequested;
use Illuminate\Support\Facades\Log;

class LogPasswordResetRequest
{
    public function handle(PasswordResetRequested $event)
    {
        Log::info('Password reset link requested for email: ' . $event->email);
    }
}
