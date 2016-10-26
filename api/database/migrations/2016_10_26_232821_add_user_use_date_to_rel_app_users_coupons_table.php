<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserUseDateToRelAppUsersCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_app_users_coupons', function ($table) {
            $table->timestamp('user_use_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rel_app_users_coupons', function($table) {
            $table->dropColumn('user_use_date');
        });
    }
}
