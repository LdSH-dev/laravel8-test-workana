<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class PasswordResetRequested
{
    use SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }
}
