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
}
