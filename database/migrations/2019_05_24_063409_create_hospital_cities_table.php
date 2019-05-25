<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_cities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('city_id');
            $table->uuid('noh_id');
            $table->uuid('noh_value');
            $table->uuid('nogh_id');
            $table->uuid('nogh_value');
            $table->uuid('noph_id');
            $table->uuid('noph_value');
            $table->uuid('noth_id');
            $table->uuid('noth_value');
            $table->uuid('noogh_id');
            $table->uuid('noogh_value');
            $table->uuid('nosh_id');
            $table->uuid('nosh_value');
            $table->uuid('nomh_id');
            $table->uuid('nomh_value');
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
        Schema::dropIfExists('hospital_cities');
    }
}
