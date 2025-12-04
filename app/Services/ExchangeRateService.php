<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\ExchangeRateRequest;
use App\Providers\exchange\ExchangeRateProviderInterface;
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
        return $this->provider->getRates();
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
