<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareCodeInfoHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_code_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->integer('app_id', false)->unsigned()->nullable();
            $table->integer('app_user_id')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('share_code_history');
    }
}
