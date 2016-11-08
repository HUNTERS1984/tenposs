<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefreshTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_refresh_token', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('refresh_token');
            $table->integer('user_id')->unique();
            $table->string('user_id_code');
            $table->integer('time_expire')->default(0);
            $table->timestamps();
            $table->index('user_id_code');
            $table->index('refresh_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_refresh_token');
    }
}
