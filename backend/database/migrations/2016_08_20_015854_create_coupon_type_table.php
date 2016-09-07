<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->nullable();
            $table->unsignedInteger('store_id',false)->nullable();
           
            $table->index('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedInteger('coupon_type_id',false)->nullable();
            $table->foreign('coupon_type_id')->references('id')->on('coupon_types');
        }); 

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign('coupons_store_id_foreign');
            $table->dropColumn('store_id');
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign('coupons_coupon_type_id_foreign');
            $table->dropColumn('coupon_type_id');
        });  

        Schema::drop('coupon_types');
    }
}
