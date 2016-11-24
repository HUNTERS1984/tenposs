<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_plans', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('service_id');
            $table->string('paypal_billing_plan_id');
            $table->timestamps();
            $table->index('service_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('billing_plans');
    }
}
