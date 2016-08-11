<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->increments('id');// Auto increments and unsigned
            $table->integer('app_id',false)->unsigned();
            $table->string('title',255)->nullable();
            $table->string('title_color',9)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->smallInteger('font_size',false);
            $table->string('font_family',100)->nullable();
            $table->string('header_color',9)->nullable();
            $table->string('menu_icon_color',9)->nullable();
            $table->string('menu_background_color',9)->nullable();
            $table->string('menu_font_color',9)->nullable();
            $table->smallInteger('menu_font_size',false)->nullable();
            $table->string('menu_font_family',100)->nullable();
            $table->integer('template_id',false)->unsigned();
            $table->string('top_main_image_url',255)->nullable();
            
            $table->index('app_id');
            $table->index('template_id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_settings');
    }
}
