<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchange_rates', function(Blueprint $table) {
            $table->id();
            $table->foreignId('currency_a_id')
                ->constrained('currencies');
            $table->foreignId('currency_b_id')
                ->constrained('currencies');
            $table->float('rate_buy')->nullable();
            $table->float('rate_sell')->nullable();
            $table->float('rate_cross')->nullable();
            $table->integer('date')->notNull();
            $table->unique([
                'currency_a_id',
                'currency_b_id',
                'date',
            ],
                'idx_currency_cross',
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
