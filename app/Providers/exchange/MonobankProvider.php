<?php

declare(strict_types=1);

namespace App\Providers\exchange;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MonobankProvider implements ExchangeRateProviderInterface
{
    private const DURATION_RATES_LIFETIME = 300;

    private const URL = 'https://api.monobank.ua/bank/currency';

    /**
     * This method is used to receive exchange rates for currencies.
     *
     * @return mixed[]
     */
    public function getRates(): array
    {
        $rates = [];
        try {
            $cacheKey = 'monobank-rates';
            /** @var mixed[]|false $rates */
            $rates = Cache::get($cacheKey);
            if ($rates === null) {
                $rates = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->get(self::URL)->json();
                Cache::set($cacheKey, $rates, self::DURATION_RATES_LIFETIME);
            }
        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
        }
        return $rates;
    }
}
