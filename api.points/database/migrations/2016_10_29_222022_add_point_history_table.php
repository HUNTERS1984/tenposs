<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('point_history', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('auth_user_id');
            $table->string('app_app_id');
            $table->string('type');//use or add
            $table->integer('points');
            $table->integer('miles');
            $table->string('role')->nullable();
            $table->timestamps();
            $table->index('app_app_id');
            $table->index('auth_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('point_history');
    }
}
