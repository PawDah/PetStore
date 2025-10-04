<?php

namespace App\Providers;

use App\Interfaces\PetStoreApiInterface;
use App\Services\PetStoreApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PetStoreApiInterface::class, PetStoreApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
