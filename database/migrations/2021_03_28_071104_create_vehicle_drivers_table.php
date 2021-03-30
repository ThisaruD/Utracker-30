<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_drivers', function (Blueprint $table) {
            $table->id('driver_id')->autoIncrement();
            $table->timestamps();
            //  $table->bigIncrements('driver_id')->unique();
            $table->string('driver_name')->nullable();
            $table->string('driver_contact_no')->nullable();


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
        Schema::dropIfExists('vehicle_drivers');
    }
}
