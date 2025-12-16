<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ExchangeRate;
use App\Repositories\Interfaces\ExchangeRateRepositoryInterface;

class ExchangeRateRepository implements ExchangeRateRepositoryInterface
{
    protected ExchangeRate $model;

    /**
     * Constructor
     */
    public function __construct(ExchangeRate $exchangeRate)
    {
        $this->model = $exchangeRate;
    }

    /**
     * @inheritDoc
     */
    public function getExchangeRateByDate(?int $startDate, ?int $endDate): array
    {
        $exchangeRates = $this->model
            ->with(['currencyA', 'currencyB'])
            ->whereIn('currency_a_id', [6, 3])
            ->whereBetween('date', [$startDate, $endDate])
            ->get(
                ['currency_a_id', 'currency_b_id', 'rate_buy', 'rate_sell', 'date']
            );
        if ($exchangeRates->isEmpty()) {
            return [];
        }
        return $exchangeRates->toArray();
    }

    /**
     * @inheritDoc
     */
    public function updateOrInsertMany(array $validExchangeRates, bool $shouldRestructure = true): int
    {
        $exchangeRates = $shouldRestructure ?
            $this->model->getRestructuredData($validExchangeRates) :
            $validExchangeRates;
        $uniqueBy = ['currency_a_id', 'currency_b_id', 'date'];
        $updateColumns = array_diff(array_keys($exchangeRates[0] ?? []), $uniqueBy);
        $this->model->upsert($exchangeRates, $uniqueBy, $updateColumns);
        return count($exchangeRates);
    }
}
