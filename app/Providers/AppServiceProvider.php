<?php

namespace App\Providers;

use App\Providers\exchange\ExchangeRateProviderInterface;
use App\Providers\exchange\MonobankProvider;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExchangeRateProviderInterface::class,
            MonobankProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
