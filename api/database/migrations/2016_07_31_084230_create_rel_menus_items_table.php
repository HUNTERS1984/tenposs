<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelMenusItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_menus_items', function (Blueprint $table) {
            $table->unsignedInteger('menu_id',false)->nullable();
            $table->unsignedInteger('item_id',false)->nullable();
            $table->primary(['menu_id','item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_menus_items');
    }
}
