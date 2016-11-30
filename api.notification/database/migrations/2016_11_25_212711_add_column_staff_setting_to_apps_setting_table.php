<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStaffSettingToAppsSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps_setting', function (Blueprint $table) {
            $table->string('staff_android_push_api_key');
            $table->string('staff_android_push_service_file');
            $table->string('staff_apple_push_cer_file');
            $table->string('staff_apple_push_cer_password');
            $table->string('google_analytics_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('apps_setting', function (Blueprint $table) {
            $table->dropColumn('staff_android_push_api_key');
            $table->dropColumn('staff_android_push_service_file');
            $table->dropColumn('staff_apple_push_cer_file');
            $table->dropColumn('staff_apple_push_cer_password');
            $table->dropColumn('google_analytics_file');
        });
    }
}
