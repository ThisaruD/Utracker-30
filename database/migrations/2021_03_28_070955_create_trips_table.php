<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id('trip_id');

            $table->timestamps();
            //   $table->bigIncrements('trip_id')->unique();
            $table->float('distance')->nullable();
            $table->float('cost')->nullable();
            $table->date('date')->nullable();


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
        Schema::dropIfExists('trips');
    }
}
