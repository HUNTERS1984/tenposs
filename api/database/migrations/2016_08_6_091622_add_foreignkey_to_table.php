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
        /*
         * stores relations
         */

        // stores has many addresses
        Schema::table('addresses', function(Blueprint $table)
        {
            $table->foreign('store_id')->references('id')->on('stores');
        });
        // stores has many photo_categories
        Schema::table('photo_categories', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores');
        });
        // stores has many reserves
        Schema::table('reserves', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores');
        });
        // stores has many menus
        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores');
        });
        // stores has many news
        Schema::table('news', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores');
        });
        // stores has many coupons
        Schema::table('coupons', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores');
        });

        /*
         * apps relations
         */

        // apps has many app_top_main_images
        Schema::table('app_top_main_images', function(Blueprint $table)
        {
            $table->foreign('app_id')->references('id')->on('apps');
        });
        // apps has many app_top_main_images
        Schema::table('rel_apps_stores', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('app_store_id')->references('id')->on('app_stores');
        });
        // apps has many app_users
        Schema::table('app_users', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
        });


        Schema::table('app_settings', function (Blueprint $table) {
            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('template_id')->references('id')->on('templates');
        });


        // users relations
        // users has many apps
        Schema::table('apps', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });


        // coupons has many items
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
        Schema::table('rel_items', function (Blueprint $table) {
            $table->foreign('related_id')->references('id')->on('items');
            $table->foreign('item_id')->references('id')->on('items');
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


        Schema::table('rel_menus_items', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('menu_id')->references('id')->on('menus');
        });


        /*
         * app users relations
         */

        // app_users has many user_messages
        Schema::table('user_messages', function (Blueprint $table) {
            $table->foreign('to_user_id')->references('id')->on('app_users');
            $table->foreign('from_user_id')->references('id')->on('app_users');
        });

        // app_users has many user_profiles
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->foreign('app_user_id')->references('id')->on('app_users');
        });
        // app_users has many user_pushs
        Schema::table('user_pushs', function (Blueprint $table) {
            $table->foreign('app_user_id')->references('id')->on('app_users');
        });
        // app_users has many user_sessions
        Schema::table('user_sessions', function(Blueprint $table)
        {
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
        //
    }
}
