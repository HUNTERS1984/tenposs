<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelAppsStoresComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_apps_stores', function (Blueprint $table) {
            $table->integer('app_id',false)->unsigned();
            $table->unsignedInteger('app_store_id');
            $table->string('app_icon_url',255)->nullable();
            $table->string('store_icon_url',255)->nullable();
            $table->string('version',10)->nullable();
            $table->string('push_notification_dev_file',255)->nullable();
            $table->string('push_notification_pro_file',255)->nullable();
            $table->string('splash_url',255)->nullable();

            $table->primary(['app_id','app_store_id']);
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_apps_stores');
    }
}
