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
            $table->engine = 'InnoDB';
            $table->integer('id',false)->unsigned();
            $table->integer('app_user_id',false)->unsigned();
            $table->string('token',255)->nullable();
            $table->smallInteger('type',false)->nullable();
            $table->timestamp('created_at');
            $table->primary(['id','app_user_id']);
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
