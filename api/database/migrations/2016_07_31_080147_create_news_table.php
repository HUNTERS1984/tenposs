<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255)->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->integer('store_id',false)->unsigned()->nullable();
            $table->string('image_url',255)->nullable();
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
        Schema::drop('news');
    }
}
