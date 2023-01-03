<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NpiRegistryService;
use App\Services\RegistryService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegistryService::class, NpiRegistryService::class);
        $this->app->bind(ClientInterface::class, Client::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
