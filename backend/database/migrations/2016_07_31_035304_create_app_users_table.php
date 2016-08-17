<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('app_users')) {
            Schema::create('app_users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email',100)->nullable();
                $table->string('password',60)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->smallInteger('social_type',false);//COMMENT '0: Facebook; 1: Twitter'
                $table->string('social_id',255)->nullable();
                $table->integer('app_id',false)->unsigned();
                $table->string('temporary_hash',60)->nullable();
                $table->string('android_push_key',255)->nullable();
                $table->string('apple_push_key',255)->nullable();
                $table->smallInteger('role',false)->unsigned();//COMMENT '0: end-user; 1 staff-user'
             
                $table->index('social_id');
                $table->index('app_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users');
    }
}
