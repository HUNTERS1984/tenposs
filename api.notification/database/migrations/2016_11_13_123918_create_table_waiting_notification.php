<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWaitingNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_app_id')->nullable();
            $table->integer('auth_user_id');
            $table->string('type')->nulable();
            $table->string('user_type')->nulable();
            $table->string('title')->nulable();
            $table->string('message')->nulable();
            $table->integer('all_user')->nulable();
            $table->integer('notification_to')->nulable();
            $table->integer('data_id')->nulable();
            $table->string('notification_time')->nulable();
            $table->timestamps();
            $table->index('app_app_id');
            $table->index('auth_user_id');
            $table->index('notification_time');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('waiting_notification');
    }
}
