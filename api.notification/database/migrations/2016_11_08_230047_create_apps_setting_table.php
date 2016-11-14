<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('apps_setting', function($table) {
            $table->increments('id');
            $table->string('app_app_id',255)->nullable();
            $table->string('android_push_api_key');
            $table->string('android_push_service_file');
            $table->string('apple_push_cer_file');
            $table->string('apple_push_cer_password');
            $table->string('web_push_server_key')->nullable();
            $table->string('web_push_sender_id')->nullable();
            $table->timestamps();
            $table->index(['app_app_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apps_setting');
    }
}
