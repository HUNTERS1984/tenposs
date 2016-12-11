<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePushColumnAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function ($table) {
            $table->dropColumn('android_push_api_key');
            $table->dropColumn('android_push_service_file');
            $table->dropColumn('apple_push_cer_file');
            $table->dropColumn('apple_push_cer_password');
            $table->dropColumn('web_push_server_key');
            $table->dropColumn('web_push_sender_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apps', function($table) {
            $table->string('android_push_api_key');
            $table->string('android_push_service_file');
            $table->string('apple_push_cer_file');
            $table->string('apple_push_cer_password');
            $table->string('web_push_server_key');
            $table->string('web_push_sender_id');
        });
    }
}
