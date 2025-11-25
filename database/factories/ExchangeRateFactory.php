<?php

declare(strict_types=1);


namespace Database\Factories;

use App\Models\ExchangeRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExchangeRateFactory extends Factory
{
    protected $model = ExchangeRate::class;

    public function definition(): array
    {
        return [
            'currency_a_id' => $this->faker->currencyCode(),
            'currency_b_id' => $this->faker->currencyCode(),
            'rate_buy' => $this->faker->randomFloat(4, 0.5, 100.0),
            'rate_sell' => $this->faker->randomFloat(4, 0.5, 100.0),
            'rate_cross' => $this->faker->randomFloat(4, 0.5, 100.0),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->getTimestamp(),
        ];
    }
}
