<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePushRelugarCurrent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_regular_current', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('app_user_id');
            $table->integer('push_id');
            $table->string('title');
            $table->string('message');
            $table->smallInteger('time_type');
            $table->integer('time_count_repeat')->nullable();
            $table->integer('time_count_delivered')->nullable();
            $table->string('time_detail_year',10)->nullable();
            $table->string('time_detail_month',10)->nullable();
            $table->string('time_detail_day',10)->nullable();
            $table->string('time_detail_type',10)->nullable();
            $table->string('time_detail_hours',10)->nullable();
            $table->string('time_detail_minutes',10)->nullable();
            $table->timestamps();
            $table->index('time_detail_day');
            $table->index('time_detail_hours');
            $table->index('time_detail_minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('push_regular_current');
    }
}
