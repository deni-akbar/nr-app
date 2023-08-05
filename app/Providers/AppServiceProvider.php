<?php

namespace App\Providers;
// use App\Repositories\BridgeRepository;
// use App\Repositories\BridgeRepository;
// use App\Repositories\BridgeRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BridgeRepository::class, function () {
            return new BridgeRepository();
        });
        $this->app->bind(VendorRepository::class, function () {
            return new VendorRepository();
        });
        $this->app->bind(UserRepository::class, function () {
            return new UserRepository();
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
