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

            $table->increments('id');
            $table->integer('app_user_id',false)->unsigned()->nullable();
            $table->string('token',255)->nullable();
            $table->smallInteger('type',false)->nullable();
            $table->timestamps();

            $table->index(['app_user_id']);
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
