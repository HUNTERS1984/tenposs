<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_sizes', function (Blueprint $table) {
            $table->increments('id');// Auto increments and unsigned
            $table->decimal('value', 5, 2);
            $table->integer('item_id',false)->unsigned()->nullable();
            $table->integer('item_size_type_id',false)->unsigned()->nullable();
            $table->integer('item_size_category_id',false)->unsigned()->nullable();
            $table->index('item_id');

            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('item_size_type_id')->references('id')->on('item_size_types');
            $table->foreign('item_size_category_id')->references('id')->on('item_size_categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public
    function down()
    {
        Schema::drop('item_sizes');
    }
}
