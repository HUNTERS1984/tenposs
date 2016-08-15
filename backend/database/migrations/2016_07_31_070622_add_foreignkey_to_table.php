<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_sessions', function(Blueprint $table)
        {
            $table->foreign('app_user_id')->references('id')->on('app_users');
        });
        Schema::table('addresses', function(Blueprint $table)
        {
            $table->foreign('app_id')->references('id')->on('apps');
        });
        Schema::table('app_settings', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('template_id')->references('id')->on('templates');
        });

        Schema::table('app_users', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::table('apps', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::table('photo_categories', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->foreign('photo_category_id')->references('id')->on('photo_categories');
        });

        Schema::table('rel_app_settings_components', function (Blueprint $table) {
            $table->foreign('component_id')->references('id')->on('components');
            $table->foreign('app_setting_id')->references('id')->on('app_settings');
        });

        Schema::table('rel_app_settings_sidemenus', function (Blueprint $table) {
            $table->foreign('sidemenu_id')->references('id')->on('sidemenus');
            $table->foreign('app_setting_id')->references('id')->on('app_settings');
        });

        Schema::table('rel_apps_stores', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('store_id')->references('id')->on('stores');
        });







    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
