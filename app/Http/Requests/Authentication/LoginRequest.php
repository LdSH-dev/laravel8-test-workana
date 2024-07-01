<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function rules() {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ];
    }
}
