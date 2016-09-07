<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPushLogTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_push_log_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',50)->nullable();
            $table->integer('data_id',false)->default(0);
            $table->string('data_value',1000)->nullable();
            $table->string('platform',50)->nullable();
            $table->string('created_by',255)->nullable();
            $table->string('updated_by',255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->smallInteger('notify_status',false)->default(0);
            $table->unsignedInteger('app_user_id',false)->nullable();
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
        Schema::drop('user_push_log_tracking');
    }
}
