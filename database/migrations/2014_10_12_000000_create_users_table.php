<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('nic')->unique()->nullable();
            $table->string('contact_no')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();



            $table->rememberToken();
            $table->timestamps();

            /////foreign keys//////
            $table->foreignId('user_roles_role_id')->nullable()
                ->references('role_id')
                ->on('user_roles');

            $table->foreignId('companies_company_id')->nullable()
                ->references('company_id')
                ->on('companies');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
