<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class AddressLookupService {
    protected $baseUrl;

    public function __construct() {
        $this->baseUrl = "https://viacep.com.br/ws/";
    }

    /**
     * Lookup address by zip code.
     *
     * @param string $zip
     * @return array|null
     * @throws \Exception
     */
    public function lookup(string $zip): ?array {
        $url = "{$this->baseUrl}{$zip}/json/";

        try {
            $response = Http::get($url);

            if ($response->successful() && !isset($response['erro'])) {
                return [
                    'logradouro' => $response['logradouro'],
                    'bairro' => $response['bairro'],
                    'localidade' => $response['localidade'],
                    'uf' => $response['uf']
                ];
            } else {
                return null;
            }
        } catch (RequestException $e) {
            throw new \Exception("Failed to lookup address: " . $e->getMessage());
        } catch (\Exception $e) {
            return null;
        }
    }
}
