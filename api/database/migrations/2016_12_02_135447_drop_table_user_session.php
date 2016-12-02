<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableUserSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('user_sessions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('user_sessions', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('app_user_id');
            $table->string('token');
            $table->smallInteger('type');

        });
    }
}
