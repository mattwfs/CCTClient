<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trials',function(Blueprint $table){
            $table->increments('id');
            $table->text('title');
            $table->text('desctiption');
            $table->text('questions')->nullable();
            $table->text('attachments')->nullable();
            $table->string('expires_on');
            $table->integer('specialization_id');
            $table->integer('requires_file')->default(0);
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
        Schema::drop('trials');
    }
}
