<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CurrencyRepository $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new CurrencyRepository(new Currency());
        $this->seed(CurrencySeeder::class);
    }

    public function tearDown(): void
    {
        unset($this->repository);
        parent::tearDown();
    }

    public function testGetIdByCodeReturnsCorrectId(): void
    {
        $result = $this->repository->getIdByCode(978); // Numeric code for EUR
        $currencyId = 3;
        $this->assertNotNull($result);
        $this->assertSame($currencyId, $result);
    }
}

