<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class PrivatBankExchangeRateService extends ServiceProvider
{
    public function getRates(): array
    {
        $response = Http::get('https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5');

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to fetch exchange rates from PrivatBank API');
    }
}
