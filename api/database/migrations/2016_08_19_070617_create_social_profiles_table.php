<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('social_type',false)->default(0);
            $table->string('social_id',255)->nullable();
            $table->string('social_token',255)->nullable();
            $table->string('social_secret',255)->nullable();
            $table->string('nickname',255)->nullable();
            $table->text('json')->nullable();
            $table->timestamps();
            $table->unsignedInteger('app_user_id',false)->nullable();

            $table->index('app_user_id');
            $table->foreign('app_user_id')->references('id')->on('app_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('social_profiles');
    }
}
