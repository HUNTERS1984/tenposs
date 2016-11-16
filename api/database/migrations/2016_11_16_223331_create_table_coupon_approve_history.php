<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCouponApproveHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_approve_history', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('app_user_id');
            $table->integer('coupon_id');
            $table->integer('staff_id');
            $table->string('action')->nullable();
            $table->timestamp('user_use_date')->nullable();
            $table->timestamp('action_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupon_approve_history');
    }
}
