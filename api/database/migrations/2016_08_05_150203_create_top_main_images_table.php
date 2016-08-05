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
        Schema::create('store_top_main_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_url',255)->nullable();
            $table->integer('store_id',false)->unsigned();
            $table->timestamps();
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('store_top_main_images');
    }
}
