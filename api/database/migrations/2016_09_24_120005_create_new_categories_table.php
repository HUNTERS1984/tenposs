<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_categories', function (Blueprint $table) {
            $table->increments('id');// Auto increments and unsigned
            $table->string('name',255)->nullable();
            $table->unsignedInteger('store_id',false)->nullable();

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
        Schema::drop('new_categories');
    }
}
