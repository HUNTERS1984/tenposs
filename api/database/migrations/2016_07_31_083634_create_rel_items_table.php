<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_items', function (Blueprint $table) {
            $table->unsignedInteger('item_id',false)->nullable();
            $table->unsignedInteger('related_id',false)->nullable();
            $table->primary(['item_id','related_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_items');
    }
}
