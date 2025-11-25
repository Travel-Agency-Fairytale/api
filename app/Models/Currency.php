<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'iso_code',
        'numeric_code',
        'minor_unit',
    ];

    public function exchangeRatesA()
    {
        return $this->hasMany(ExchangeRate::class, 'currency_a_id');
    }

    public function exchangeRatesB()
    {
        return $this->hasMany(ExchangeRate::class, 'currency_b_id');
    }

    /**
     * Returns currency Id by numeric code.
     *
     * @param int $code Numeric currency code.
     * @return int|null
     */
    public static function getIdByCode(int $code): ?int
    {
        $currency = self::findOne(['numeric_code' => $code]);
        if ($currency !== null) {
            return $currency->id;
        }
        return $currency;
    }
}
