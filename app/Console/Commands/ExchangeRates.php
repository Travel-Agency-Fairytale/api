<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets and stores exchange rates from external API';

    /**
     * Execute the console command.
     */
    public function handle(ExchangeRateService $ExchangeRateService)
    {
        try {
            $apiData = $ExchangeRateService->fetch();
            if (!empty($apiData)) {
                $this->info('Fetched exchange rates data from API');
                $validated = $ExchangeRateService->validate($apiData);
                $model = new ExchangeRate();
                $data = $model->getRestructuredData($validated);
                $result = $model->insert($data);
                $this->info('Saved to Exchange Rates table ' . $result . ' rows');
                return CommandAlias::SUCCESS;
            }
            $this->error('Failed to fetch exchange rates data: empty response from API');
            return CommandAlias::FAILURE;
        } catch (Exception $e) {
            $this->error('Failed to fetch exchange rates data: ' . $e->getMessage());
            return CommandAlias::FAILURE;
        }
    }
}
