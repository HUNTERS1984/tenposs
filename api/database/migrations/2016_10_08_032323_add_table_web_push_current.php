<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableWebPushCurrent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_push_current', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('type',50);
            $table->integer('data_id',false)->default(0);
            $table->string('data_value',1000)->nullable();
            $table->string('title',100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('app_user_id',false)->nullable();
            $table->index('app_user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('web_push_current');
    }
}
