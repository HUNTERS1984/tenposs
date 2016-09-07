<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationToApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function($table) {
            $table->string('android_push_api_key');
            $table->string('android_push_service_file');
            $table->string('apple_push_cer_file');
            $table->string('apple_push_cer_password');
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
            $table->dropColumn('android_push_api_key');
            $table->dropColumn('android_push_service_file');
            $table->dropColumn('apple_push_cer_file');
            $table->dropColumn('apple_push_cer_password');
        });
    }
}