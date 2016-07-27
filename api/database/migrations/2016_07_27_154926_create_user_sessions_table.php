<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->integer('id',10);
            $table->integer('app_user_id',10);
            $table->string('token',255);
            $table->smallInteger('type',4);
            $table->timestamps();

            $table->primary('id');
            $table->foreign('app_user_id')->references('id')->on('app_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_sessions');
    }
}
