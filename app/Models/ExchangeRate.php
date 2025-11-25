<?php

namespace App\Models;

use App\Repositories\CurrencyRepository;
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
    public function getRestructuredData(array $apiData, CurrencyRepository $CurrencyRepository): array
    {
        $data = [];
        foreach ($apiData as $item) {
            $exchangeRate = $this->model::newInstance([
                'currency_a_id' => $CurrencyRepository->getIdByCode($item['currencyCodeA']),
                'currency_b_id' => $CurrencyRepository->getIdByCode($item['currencyCodeB']),
                'date' => $item['date'],
                'rate_buy' => $item['rateBuy'] ?? null,
                'rate_sell' =>  $item['rateSell'] ?? null,
                'rate_cross' => $item['rateCross'] ?? null,
            ]);
//            $exchangeRate->currency_a_id = Currency::getIdByCode($item['currencyCodeA']);
//            $exchangeRate->currency_b_id = Currency::getIdByCode($item['currencyCodeB']);
//            $exchangeRate->date = $item['date'];
//            $exchangeRate->rate_buy = $item['rateBuy'] ?? null;
//            $exchangeRate->rate_sell = $item['rateSell'] ?? null;
//            $exchangeRate->rate_cross = $item['rateCross'] ?? null;
//            if ($exchangeRate->validate()) {
//                $data[] = $exchangeRate->toArray();
//            } else {
//                Log::warning("Invalid exchange rate: " . json_encode($exchangeRate->getErrors()));
//            }
        }
        return $data;
    }
}
