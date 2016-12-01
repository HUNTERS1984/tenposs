<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointRequestHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('point_request_history', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_request_id')->nullable();
            $table->integer('user_action_id')->nullable();
            $table->string('app_app_id');
            $table->string('action');//use or add
            $table->integer('status'); // 0:new ; 1: accept; 2: reject
            $table->integer('miles');
            $table->string('role_request')->nullable();
            $table->string('role_action')->nullable();
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
        Schema::drop('point_request_history');
    }
}
