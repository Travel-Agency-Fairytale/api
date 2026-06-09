<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ExchangeRateRequest;
use App\Providers\exchange\ExchangeRateProviderInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ExchangeRateService
{
    /**
     * Construct
     *
     * @param ExchangeRateProviderInterface $provider Exchange rate data provider
     */
    public function __construct(private ExchangeRateProviderInterface $provider)
    {
    }

    /**
     * Fetch exchange rates data from provider.
     *
     * @return mixed[]
     */
    public function fetch(): array
    {
        // Check if cached data exists and is not expired
        if ($cachedData = Cache::get('exchange_rates')) {
            return $cachedData;
        }

        try {
            $apiData = $this->provider->getRates();
            Cache::put('exchange_rates', $apiData, now()->addHours(24)); // Cache for 24 hours
            return $apiData;
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Failed to fetch exchange rates: ' . $e->getMessage());
            throw new \RuntimeException('Failed to fetch exchange rates', 0, $e);
        }
    }

    /**
     * Validate exchange rates data.
     *
     * @param mixed[] $apiData Exchange rates data from provider
     * @return mixed[]
     */
    public function validate(array $apiData): array
    {
        $rules = (new ExchangeRateRequest())->rules();
        $validatedData = [];
        foreach ($apiData as $data) {
            $validatedData[] = Validator::make($data, $rules)->validate();
        }
        return $validatedData;
    }
}
