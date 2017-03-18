<?php

namespace GoldPrices\Providers;

use GoldPrices\Core\GoldPricesFetching\GoldPricesFetchingInterface;
use GoldPrices\Core\NbpApi\NbpApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GoldPricesFetchingInterface::class, NbpApiService::class);
    }
}
