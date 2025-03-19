<?php

namespace App\Providers;

use App\Services\BasketService;
use App\Services\PricingStrategy\DefaultPricingStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BasketService::class, function () {
            return new BasketService(new DefaultPricingStrategy());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
