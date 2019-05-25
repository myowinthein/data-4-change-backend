<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrinkingWaterCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinking_water_cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('city_id');
            $table->uuid('tap_id');
            $table->uuid('tap_value');
            $table->uuid('borehole_id');
            $table->uuid('borehole_value');
            $table->uuid('well_id');
            $table->uuid('well_value');
            $table->uuid('pool_id');
            $table->uuid('pool_value');
            $table->uuid('river_id');
            $table->uuid('river_value');
            $table->uuid('waterfall_id');
            $table->uuid('waterfall_value');
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
        Schema::dropIfExists('drinking_water_cities');
    }
}
