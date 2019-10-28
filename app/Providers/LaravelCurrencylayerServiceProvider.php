<?php


namespace App\Providers;

use App\Services\CurrencyLayerInterface;
use App\Services\CurrencyService;
use Illuminate\Support\ServiceProvider;

class LaravelCurrencylayerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CurrencyLayerInterface::class, function ($app) {
            if(!config('services.apilayerKey')) {
                throw new \Exception('provide API KEY', 500);
            }

            return new CurrencyService(config('services.apilayerKey'));
        });
    }
}
