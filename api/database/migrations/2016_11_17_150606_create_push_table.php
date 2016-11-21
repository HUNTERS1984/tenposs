<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pushes', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('app_user_id');
            $table->string('title');
            $table->string('message');
            $table->smallInteger('time_type');
            $table->smallInteger('status');
            $table->timestamps();
            $table->index('status');
            $table->index('app_user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pushes');
    }
}
