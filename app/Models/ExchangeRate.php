<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    public $timestamps = false;

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

    /**
     * This method is used to restructure data to save all in one SQL query.
     *
     * @param mixed[] $date Date array
     * @return mixed[]
     */
    public function getRestructuredData(array $apiData): array
    {
        $data = [];
        foreach ($apiData as $item) {
            $exchangeRate = self::newInstance([
                'currency_a_id' => $this->currencyA()->getRelated()->getIdByCode($item['currencyCodeA']),
                'currency_b_id' => $this->currencyA()->getRelated()->getIdByCode($item['currencyCodeB']),
                'date' => $item['date'],
                'rate_buy' => $item['rateBuy'] ?? null,
                'rate_sell' =>  $item['rateSell'] ?? null,
                'rate_cross' => $item['rateCross'] ?? null,
            ]);
            $data[] = $exchangeRate->toArray();
        }
        return $data;
    }
}
