<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface CurrencyRepositoryInterface
{
    /**
     * Returns currency Id by numeric code.
     *
     * @param int $code Numeric currency code.
     * @return int|null
     */
    public function getIdByCode(int $code): ?int;
}
