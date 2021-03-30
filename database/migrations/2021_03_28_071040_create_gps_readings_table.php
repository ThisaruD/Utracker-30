<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpsReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_readings', function (Blueprint $table) {
            $table->id('gps_reading_id');
            $table->timestamps();
            //$table->bigIncrements('gps_reading_id')->unique();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('engine_condition')->nullable();
            $table->dateTime('time')->nullable();
            $table->integer('speed')->nullable();


            /////foreign keys//////
            $table->foreignId('vehicles_vehicle_id')
                ->references('vehicle_id')
                ->on('vehicles');

            $table->foreignId('gps_devices_device_id')
                ->references('device_id')
                ->on('vehicle_gps_devices');

            $table->foreignId('trips_trip_id')
                ->references('trip_id')
                ->on('trips');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gps_readings');
    }
}
