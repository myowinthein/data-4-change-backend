<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveStockTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_stock_cities_tables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('city_id');
            $table->uuid('beef_id');
            $table->uuid('beef_value');
            $table->uuid('pork_id');
            $table->uuid('pork_value');
            $table->uuid('chicken_id');
            $table->uuid('chicken_value');
            $table->uuid('milk_id');
            $table->uuid('milk_value');
            $table->uuid('fish_id');
            $table->uuid('fish_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_stock_tables');
    }
}
