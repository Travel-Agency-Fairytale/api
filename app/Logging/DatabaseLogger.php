<?php

declare(strict_types=1);

namespace App\Logging;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class DatabaseLogger extends AbstractProcessingHandler
{
    /**
     * @inheritDoc
     */
    protected function write(LogRecord $record): void
    {
        DB::table('logs')->insert([
            'level' => $record['level_name'],
            'message' => $record['message'],
            'context' => json_encode($record['context']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
