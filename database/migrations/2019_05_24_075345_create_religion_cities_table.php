<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReligionCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('religion_cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('city_id');
            $table->uuid('buddhist_id');
            $table->uuid('buddhist_value');
            $table->uuid('christian_id');
            $table->uuid('christian_value');
            $table->uuid('hindu_id');
            $table->uuid('hindu_value');
            $table->uuid('muslim_id');
            $table->uuid('muslim_value');
            $table->uuid('animist_id');
            $table->uuid('animist_value');
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
        Schema::dropIfExists('religion_cities');
    }
}
