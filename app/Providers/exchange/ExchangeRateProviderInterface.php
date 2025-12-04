<?php

declare(strict_types=1);

namespace App\Providers\exchange;

interface ExchangeRateProviderInterface
{
    /**
     * @return mixed[] Returns an array of exchange rate data
     */
    public function getRates(): array;
}
