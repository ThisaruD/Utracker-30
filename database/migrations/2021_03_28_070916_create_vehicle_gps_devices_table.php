<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleGpsDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_gps_devices', function (Blueprint $table) {
            $table->id('device_id');
            $table->timestamps();
            //$table->bigIncrements('device_id')->unique();
            $table->string('serial_number')->nullable();
            $table->string('status')->nullable();

            /////foreign keys//////
            $table->foreignId('vehicles_vehicle_id')
                ->references('vehicle_id')
                ->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_gps_devices');
    }
}
