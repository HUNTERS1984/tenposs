<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFontSizeToStringAppSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_settings', function ($table) {
            $table->string('font_size',50)->change();
            $table->string('menu_font_size',50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_settings', function ($table) {
            $table->smallInteger('font_size')->change();
            $table->smallInteger('menu_font_size')->change();
        });
    }
}
