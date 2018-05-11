<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('photo')->default('dummy-user.jpg');
            $table->string('password');
            
            $table->string('phone')->nullable();
            $table->string('street_address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('practise_name')->nullable();
            
            $table->integer('specialization_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->integer('is_partner')->default(0);
            $table->integer('is_active')->default(0);
            $table->integer('is_complete')->default(0);
            $table->string('reset_key')->nullable();
            $table->rememberToken();
            $table->string('deleted_at')->nullable();
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
        Schema::drop('users');
    }
}
