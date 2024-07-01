<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\AddressLookupService;

class AddressController extends Controller {
    protected $addressService;

    public function __construct(AddressLookupService $addressService) {
        $this->addressService = $addressService;
    }

    public function getAddress($zip) {
        $address = $this->addressService->lookup($zip);

        if ($address) {
            return response()->json($address);
        } else {
            return response()->json(['error' => 'CEP não encontrado'], 404);
        }
    }
}
