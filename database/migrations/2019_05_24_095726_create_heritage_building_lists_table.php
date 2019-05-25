<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeritageBuildingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heritage_building_lists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('hertigage_building_city_id');
            $table->string('name_en');
            $table->string('name_mm');
            $table->string('location_en');
            $table->string('location_mm');
            $table->string('zone_en');
            $table->string('zone_mm');
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
        Schema::dropIfExists('heritage_building_lists');
    }
}
