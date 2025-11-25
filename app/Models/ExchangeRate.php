<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'currency_a_id',
        'currency_b_id',
        'rate_buy',
        'rate_sell',
        'rate_cross',
        'date',
    ];

    public function currencyA()
    {
        return $this->belongsTo(Currency::class, 'currency_a_id');
    }

    public function currencyB()
    {
        return $this->belongsTo(Currency::class, 'currency_b_id');
    }
}
