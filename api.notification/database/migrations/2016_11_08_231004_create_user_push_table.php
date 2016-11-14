<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPushTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pushes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_app_id')->nullable();
            $table->string('app_type',20)->nullable(); //user/staff
            $table->integer('auth_user_id');
            $table->string('android_push_key')->nulable();
            $table->string('apple_push_key')->nulable();
            $table->string('web_push_key')->nulable();
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
        Schema::drop('user_pushes');
    }
}
