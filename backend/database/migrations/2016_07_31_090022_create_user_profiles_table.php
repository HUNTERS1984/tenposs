<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->nullable();
            $table->smallInteger('gender',false)->default(0);
            $table->string('address',255)->nullable();
            $table->string('avatar_url',255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->smallInteger('facebook_status',false)->default(0);
            $table->smallInteger('twitter_status',false)->default(0);
            $table->smallInteger('instagram_status',false)->default(0);
            $table->string('facebook_token',255)->nullable();
            $table->string('twitter_token',255)->nullable();
            $table->string('instagram_token',255)->nullable();
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
        Schema::drop('user_profiles');
    }
}
