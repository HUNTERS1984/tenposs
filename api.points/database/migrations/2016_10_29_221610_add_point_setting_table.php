<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('point_setting', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('app_app_id');
            $table->integer('yen_to_mile')->nullable();
            $table->integer('mile_to_point')->nullable();
            $table->integer('max_point_use')->nullable();
            $table->integer('bonus_miles_1')->nullable(); // for signup
            $table->integer('bonus_miles_2')->nullable(); // for shop comming
            $table->integer('rank1')->nullable();
            $table->integer('rank2')->nullable();
            $table->integer('rank3')->nullable();
            $table->integer('rank4')->nullable();
            $table->integer('payment_method');
            $table->timestamps();
            $table->index('app_app_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('point_setting');
    }
}
