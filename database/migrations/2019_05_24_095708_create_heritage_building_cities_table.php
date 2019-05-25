<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeritageBuildingCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heritage_building_cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('city_id');
            $table->uuid('nob_id');
            $table->uuid('nob_value');
            $table->integer('year');
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
        Schema::dropIfExists('heritage_building_cities');
    }
}
