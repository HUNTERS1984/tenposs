<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact',function (Blueprint $table){
            $table->increments('id');
            $table->string('company');
            $table->string('bussiness');
            $table->string('fullname');
            $table->string('nickname');
            $table->string('phone');
            $table->string('email');
            $table->string('reason');
            $table->string('message');
            $table->boolean('viewed')->default('0');
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
        Schema::drop('contact');
    }
}
