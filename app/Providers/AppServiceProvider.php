<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\AddressLookupService;
use App\Http\Services\AuthenticationService;
use App\Http\Services\ForgotPasswordService;
use App\Http\Services\PasswordResetService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(AuthenticationService::class, function ($app) {
            return new AuthenticationService();
        });
        $this->app->singleton(PasswordResetService::class, function ($app) {
            return new PasswordResetService();
        });
        $this->app->singleton(ForgotPasswordService::class, function ($app) {
            return new ForgotPasswordService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
