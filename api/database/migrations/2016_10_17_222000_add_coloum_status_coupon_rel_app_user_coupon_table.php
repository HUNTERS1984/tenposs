<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumStatusCouponRelAppUserCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_app_users_coupons', function ($table) {
            $table->smallInteger('status',false)->nullable();;
            $table->integer('staff_id',false)->nullable();
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
            $table->dropColumn('status');
            $table->dropColumn('staff_id');
        });
    }
}
