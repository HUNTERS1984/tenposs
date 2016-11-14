<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppTypeToUserPushSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_push_settings', function (Blueprint $table) {
            $table->string('app_type',20)->nullable(); //user/staff
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('user_push_settings', function (Blueprint $table) {
            $table->dropColumn('app_type');
        });
    }
}
