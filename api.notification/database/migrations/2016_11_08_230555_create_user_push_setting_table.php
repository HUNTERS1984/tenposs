<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPushSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_push_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('ranking',false)->default(1);
            $table->smallInteger('news',false)->default(1);
            $table->smallInteger('coupon',false)->default(1);
            $table->smallInteger('chat',false)->default(1);
            $table->smallInteger('other',false)->default(1);
            $table->string('app_app_id')->nullable();
            $table->integer('auth_user_id');
            $table->timestamps();

            $table->index('app_app_id');
            $table->index('auth_user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_push_settings');
    }
}
