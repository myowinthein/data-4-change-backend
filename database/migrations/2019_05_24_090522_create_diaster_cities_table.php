<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiasterCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaster_cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('city_id');
            $table->uuid('storm_id');
            $table->uuid('storm_value');
            $table->uuid('flood_id');
            $table->uuid('flood_value');
            $table->uuid('earthquake_id');
            $table->uuid('earthquake_value');
            $table->uuid('landslide_id');
            $table->uuid('landslide_value');
            $table->uuid('drought_id');
            $table->uuid('drought_value');
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
        Schema::dropIfExists('diaster_cities');
    }
}
