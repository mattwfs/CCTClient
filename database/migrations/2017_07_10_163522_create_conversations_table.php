<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations',function($t){
            $t->increments('id');
            $t->integer('user_a');
            $t->foreign('user_a')->references('id')->on('users');
            $t->integer('user_b');
            $t->foreign('user_b')->references('id')->on('users');
            //$t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conversations');
    }
}
