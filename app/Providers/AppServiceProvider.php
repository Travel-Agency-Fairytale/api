<?php

namespace App\Providers;

use App\Providers\exchange\ExchangeRateProviderInterface;
use App\Providers\exchange\MonobankProvider;
use App\Repositories\ExchangeRateRepository;
use App\Repositories\Interfaces\ExchangeRateRepositoryInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public $bindings = [
        ExchangeRateProviderInterface::class => MonobankProvider::class,
        ExchangeRateRepositoryInterface::class => ExchangeRateRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
