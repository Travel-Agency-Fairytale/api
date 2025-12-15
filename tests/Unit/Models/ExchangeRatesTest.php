<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\ExchangeRate;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExchangeRatesTest extends TestCase
{
    use RefreshDatabase;

    private ExchangeRate $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new ExchangeRate();
        $this->seed(CurrencySeeder::class);
    }

    public function tearDown(): void
    {
        unset($this->model);
        parent::tearDown();
    }

    public function testGetRestructuredData(): void
    {
        $data = [
            [
                "currencyCodeA" => 886,
                "currencyCodeB" => 980,
                "date" => 1765749605,
                "rateCross" => 0.1688,
            ],
            [
                "currencyCodeA" => 710,
                "currencyCodeB" => 980,
                "date" => 1765833931,
                "rateCross" => 2.5205,
            ],
        ];
        $expected = [
            [
                'currency_a_id' => 139,
                'currency_b_id' => 1,
                'date' => 1765749605,
                'rate_buy' => null,
                'rate_sell' => null,
                'rate_cross' => 0.1688,
            ],
            [
                'currency_a_id' => 140,
                'currency_b_id' => 1,
                'date' => 1765833931,
                'rate_buy' => null,
                'rate_sell' => null,
                'rate_cross' => 2.5205,
            ],
        ];
        $result = $this->model->getRestructuredData($data);
        $this->assertSame($expected, $result);
    }
}
