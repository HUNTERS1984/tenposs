<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelAppSettingsSidemenusComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_app_settings_sidemenus', function (Blueprint $table) {
            $table->unsignedInteger('app_setting_id',false)->nullable();
            $table->unsignedInteger('sidemenu_id',false)->nullable();
            $table->smallInteger('order',false)->nullable();

            $table->primary(['app_setting_id','sidemenu_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_app_settings_sidemenus');
    }
}
