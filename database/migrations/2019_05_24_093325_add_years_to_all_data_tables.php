<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearsToAllDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diaster_cities', function (Blueprint $table) {
            $table->integer('year')->before('created_at');
        });

        Schema::table('drinking_water_cities', function (Blueprint $table) {
            $table->integer('year')->before('created_at');
        });

        Schema::table('hospital_cities', function (Blueprint $table) {
            $table->integer('year')->before('created_at');
        });

        Schema::table('live_stock_cities_tables', function (Blueprint $table) {
            $table->integer('year')->before('created_at');
        });

        Schema::table('religion_cities', function (Blueprint $table) {
            $table->integer('year')->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('all_data_tables', function (Blueprint $table) {
            //
        });
    }
}
