<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->nullable();
            $table->integer('store_id',false)
                ->unsigned()
                ->nullable();
            $table->index('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
        });

        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->nullable();
            $table->string('price',100)->nullable();
            $table->string('image_url',255)->nullable();
            $table->text('introduction')->nullable();
            $table->smallInteger('gender')->nullable();
            $table->date('birthday',60);
            $table->string('tel',20)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('staff_category_id',false)
                ->unsigned()
                ->nullable();
            $table->index('staff_category_id');
            $table->foreign('staff_category_id')->references('id')->on('staff_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staffs');
        Schema::drop('staff_categories');
    }
}
