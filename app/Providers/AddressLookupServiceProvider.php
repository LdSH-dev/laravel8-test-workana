<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\AddressLookupService;

class AddressLookupServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(AddressLookupService::class, function () {
            return new AddressLookupService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
