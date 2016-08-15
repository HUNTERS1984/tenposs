<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopMainImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // (id, image_url,created_at,updated_at, storeid)
        Schema::create('app_top_main_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_url',255)->nullable();
            $table->integer('app_setting_id',false)->unsigned()->nullable();
            $table->timestamps();
            $table->index('app_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_top_main_images');
    }
}
