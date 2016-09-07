<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_coupon_id_foreign');
            $table->dropColumn('coupon_id');
        });       

        Schema::create('rel_app_users_coupons', function (Blueprint $table) {
            $table->unsignedInteger('app_user_id',false)->nullable();
            $table->unsignedInteger('coupon_id',false)->nullable();
            $table->primary(['app_user_id','coupon_id']);
            $table->foreign('app_user_id')->references('id')->on('app_users');
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_app_users_coupons');
    }
}
