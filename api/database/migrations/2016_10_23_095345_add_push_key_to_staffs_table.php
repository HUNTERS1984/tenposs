<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPushKeyToStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staffs', function ($table) {
            $table->string('android_push_key')->nullable();;
            $table->string('apple_push_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staffs', function($table) {
            $table->dropColumn('android_push_key');
            $table->dropColumn('apple_push_key');
        });
    }
}
