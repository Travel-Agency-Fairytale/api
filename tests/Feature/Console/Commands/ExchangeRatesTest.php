<?php

declare(strict_types=1);

namespace Feature\Console\Commands;

use App\Console\Commands\ExchangeRates;
use App\Repositories\Interfaces\ExchangeRateRepositoryInterface;
use App\Services\ExchangeRateService;
use Exception;
use Mockery;
use Tests\TestCase;

class ExchangeRatesTest extends TestCase
{
    public function testHandleFetchAndSaveSuccessfully(): void
    {
        $apiData = [
            [
                "currencyCodeA" => 704,
                "currencyCodeB" => 980,
                "date" => 1765978130,
                "rateCross" => 0.0016,
            ],
            [
                "currencyCodeA" => 764,
                "currencyCodeB" => 980,
                "date" => 1765978179,
                "rateCross" => 1.356,
            ],

        ];
        $validatedData = $apiData;
        $savedRows = 2;
        $exchangeRateService = Mockery::mock(ExchangeRateService::class);
        $exchangeRateService->shouldReceive('fetch')
            ->once()
            ->andReturn($apiData);
        $exchangeRateService->shouldReceive('validate')
            ->once()
            ->with($apiData)
            ->andReturn($validatedData);
        $exchangeRateRepository = Mockery::mock(ExchangeRateRepositoryInterface::class);
        $exchangeRateRepository->shouldReceive('updateOrInsertMany')
            ->once()
            ->with($validatedData)
            ->andReturn($savedRows);
        $command = new ExchangeRates($exchangeRateRepository);
        $this->app->instance(ExchangeRateService::class, $exchangeRateService);
        $this->app->instance(ExchangeRateRepositoryInterface::class, $exchangeRateRepository);
        $this->artisan('app:exchange-rates')
            ->expectsOutput('Fetched exchange rates data from API')
            ->expectsOutput('Saved to Exchange Rates table 2 rows')
            ->assertExitCode($command::SUCCESS);
    }

    public function testHandleFailsWhenApiReturnsEmptyResponse(): void
    {
        $exchangeRateService = Mockery::mock(ExchangeRateService::class);
        $exchangeRateService->shouldReceive('fetch')
            ->once()
            ->andReturn([]);
        $exchangeRateRepository = Mockery::mock(ExchangeRateRepositoryInterface::class);
        $command = new ExchangeRates($exchangeRateRepository);
        $this->app->instance(ExchangeRateService::class, $exchangeRateService);
        $this->app->instance(ExchangeRateRepositoryInterface::class, $exchangeRateRepository);
        $this->artisan('app:exchange-rates')
            ->expectsOutput('Failed to fetch exchange rates data: empty response from API')
            ->assertExitCode($command::FAILURE);
    }

    public function testFailsWhenExceptionIsThrown(): void
    {
        $exchangeRateService = Mockery::mock(ExchangeRateService::class);
        $exchangeRateService->shouldReceive('fetch')
            ->once()
            ->andThrow(new Exception('API error'));
        $exchangeRateRepository = Mockery::mock(ExchangeRateRepositoryInterface::class);
        $command = new ExchangeRates($exchangeRateRepository);
        $this->app->instance(ExchangeRateService::class, $exchangeRateService);
        $this->app->instance(ExchangeRateRepositoryInterface::class, $exchangeRateRepository);
        $this->artisan('app:exchange-rates')
            ->expectsOutput('Failed to fetch exchange rates data: API error')
            ->assertExitCode($command::FAILURE);
    }
}
