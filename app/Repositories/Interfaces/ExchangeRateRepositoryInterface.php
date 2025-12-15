<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface ExchangeRateRepositoryInterface
{
    /**
     * This method is used to get exchange rates by date.
     *
     * @param int|null $startDate Start date
     * @param int|null $endDate End date
     * @return mixed[]
     */
    public function getExchangeRateByDate(?int $startDate, ?int $endDate): array;

    /**
     * This method is used to update or insert multiple exchange rates.
     *
     * @param mixed[] $validExchangeRates Array of valid exchange rates
     * @param bool $shouldRestructure Indicates whether restructuring is needed
     * @return int Number of exchange rates updated or inserted
     */
    public function updateOrInsertMany(array $validExchangeRates, bool $shouldRestructure = true): int;
}
