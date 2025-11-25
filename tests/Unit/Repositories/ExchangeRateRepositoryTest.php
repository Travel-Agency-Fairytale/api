<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Models\ExchangeRate;
use App\Repositories\ExchangeRateRepository;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExchangeRateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ExchangeRateRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new ExchangeRateRepository(new ExchangeRate());
        $this->seed(CurrencySeeder::class);
    }

    public function tearDown(): void
    {
        unset($this->repository);
        parent::tearDown();
    }

    public function testGetExchangeRateByDateReturnsData(): void
    {
        $startDate = strtotime('-1 month');
        $endDate = time();
        $date1 = strtotime('-15 days');
        ExchangeRate::factory()->create([
            'currency_a_id' => 6,
            'currency_b_id' => 3,
            'rate_buy' => 1.2345,
            'rate_sell' => 1.3456,
            'date' => $date1,
        ]);
        $date2 = strtotime('-10 days');
        ExchangeRate::factory()->create([
            'currency_a_id' => 3,
            'currency_b_id' => 6,
            'rate_buy' => 0.9876,
            'rate_sell' => 1.0987,
            'date' => $date2,
        ]);
        $result = $this->repository->getExchangeRateByDate($startDate, $endDate);
        $this->assertNotEmpty($result);
        $this->assertCount(2, $result);
        $expected = [
            [
                "currency_a_id" => 3,
                "currency_b_id" => 6,
                "rate_buy" => 0.9876,
                "rate_sell" => 1.0987,
                "date" => $date2,
                "currency_a" => [
                    "id" => 3,
                    "name" => "Euro",
                    "iso_code" => "EUR",
                    "numeric_code" => "978",
                    "minor_unit" => "2",
                ],
                "currency_b" => [
                    "id" => 6,
                    "name" => "US Dollar",
                    "iso_code" => "USD",
                    "numeric_code" => "840",
                    "minor_unit" => "2",
                ]
            ],
            [
                "currency_a_id" => 6,
                "currency_b_id" => 3,
                "rate_buy" => 1.2345,
                "rate_sell" => 1.3456,
                "date" => $date1,
                "currency_a" => [
                    "id" => 6,
                    "name" => "US Dollar",
                    "iso_code" => "USD",
                    "numeric_code" => "840",
                    "minor_unit" => "2",
                ],
                "currency_b" => [
                    "id" => 3,
                    "name" => "Euro",
                    "iso_code" => "EUR",
                    "numeric_code" => "978",
                    "minor_unit" => "2",
                ]
              ]
        ];
        $this->assertSame($expected, $result);
    }

    public function testGetExchangeRateByDateReturnsEmptyArray(): void
    {
        $startDate = strtotime('-2 years');
        $endDate = strtotime('-1 year');
        $result = $this->repository->getExchangeRateByDate($startDate, $endDate);
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}

