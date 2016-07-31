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
                $table->integer('id',10)->unsigned();
                $table->string('email',100)->nullable();
                $table->string('password',60)->nullable();
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
                $table->timestamp('deleted_at');
                $table->smallInteger('social_type',false);//COMMENT '0: Facebook; 1: Twitter'
                $table->string('social_id',255)->nullable();
                $table->integer('app_id',false)->unsigned();
                $table->string('temporary_hash',60)->nullable();
                $table->string('android_push_key',255)->nullable();
                $table->string('apple_push_key',255)->nullable();
                $table->smallInteger('role',false)->unsigned();//COMMENT '0: end-user; 1 staff-user'
                $table->primary(['id','app_id']);
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
