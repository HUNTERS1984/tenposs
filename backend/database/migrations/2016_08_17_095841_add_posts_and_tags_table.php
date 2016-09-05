<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostsAndTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('social_user_id')->nullable();
            $table->string('social_user_name', 100)->nullable();
            $table->string('social_user_avatar', 255)->nullable();
            $table->string('social_media_id', 50)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('caption', 200)->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('created_time')->nullable();
            $table->tinyInteger('status')->nullable();  // 0:有効 9:利用停止

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rel_posts_tags', function (Blueprint $table) {
            $table->unsignedInteger('post_id',false)->nullable();
            $table->unsignedInteger('tag_id',false)->nullable();
            
            $table->primary(['post_id','tag_id']);
        });

        Schema::create('rel_coupons_tags', function (Blueprint $table) {
            $table->unsignedInteger('coupon_id',false)->nullable();
            $table->unsignedInteger('tag_id',false)->nullable();
            
            $table->primary(['coupon_id','tag_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_coupons_tags');
        Schema::drop('rel_posts_tags');
        Schema::drop('posts');
        Schema::drop('tags');
    }
}
