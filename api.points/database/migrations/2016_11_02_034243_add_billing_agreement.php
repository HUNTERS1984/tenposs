<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingAgreement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_agreements', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('billing_plan_id')->unsigned();
            $table->string('paypal_billing_agreement_id')->nullable();
            $table->string('paypal_token')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('status')->unsigned();
            $table->timestamps();

        });

        Schema::table('billing_agreements', function(Blueprint $table)
        {
            $table->foreign('billing_plan_id')->references('id')->on('billing_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_agreements', function (Blueprint $table) {
            $table->dropForeign('billing_agreements_billing_plan_id_foreign');
        }); 

        Schema::drop('billing_agreements');
    }
}
