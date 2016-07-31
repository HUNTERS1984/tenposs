<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPushsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pushs', function (Blueprint $table) {
            $table->unsignedInteger('id',false);
            $table->smallInteger('ranking',false)->default(1);
            $table->smallInteger('news',false)->default(1);
            $table->smallInteger('coupon',false)->default(1);
            $table->smallInteger('chat',false)->default(1);
            $table->unsignedInteger('app_user_id',false)->nullable();

            $table->primary(['id']);
            $table->index('app_user_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_pushs');
    }
}
