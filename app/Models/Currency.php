<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
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
}
