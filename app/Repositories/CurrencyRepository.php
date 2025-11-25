<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    protected Currency $model;

    /**
     * Constructor
     */
    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    /**
     * @inheritDoc
     */
    public function getIdByCode(int $code): ?int
    {
        //TODO optimize query with caching
        $result = $this->model
            ->where('numeric_code', $code)
            ->value('id');
        return $result !== null ? (int)$result : null;
    }
}
