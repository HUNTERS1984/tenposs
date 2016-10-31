<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointRequestUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('point_request_use', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_request_id');
            $table->string('app_app_id');
            $table->string('role_request')->nullable();
            $table->integer('points');
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
        Schema::drop('point_request_use');
    }
}
