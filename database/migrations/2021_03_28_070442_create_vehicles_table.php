<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id')->autoIncrement();
            //$table->bigIncrements('vehicle_id')->unique();
            $table->string('vehicle_number')->unique();
            $table->string('type')->nullable();
            $table->integer('unit_per_1km')->nullable();
            $table->dateTime('added_at')->nullable();

            //////inherited key attributes///////
//            $table->unsignedBigInteger('');


            /////foreign keys//////
            $table->foreignId('users_id')
                ->references('id')
                ->on('users');

            $table->foreignId('vehicle_owners_owner_id')
                ->references('owner_id')
                ->on('vehicle_owners');


            $table->foreignId('companies_company_id')
                ->references('company_id')
                ->on('companies');

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
        Schema::dropIfExists('vehicles');
    }
}
