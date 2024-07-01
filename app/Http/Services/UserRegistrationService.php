<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Events\UserRegisteredEvent;

class UserRegistrationService {
    protected $addressService;

    public function __construct(AddressLookupService $addressService) {
        $this->addressService = $addressService;
    }

    public function register(array $data) {
        $address = $this->addressService->lookup($data['zip']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $address,
        ]);

        Event::dispatch(new UserRegisteredEvent($user));

        return $user;
    }
}
