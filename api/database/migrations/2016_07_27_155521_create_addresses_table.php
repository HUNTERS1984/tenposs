<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->integer('id',10)->unsigned();
            $table->string('lat',20);
            $table->string('long',20);
            $table->string('tel',20);
            $table->string('title',100);
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('app_id',10)->unsigned();
            $table->primary('id');
            $table->foreign('app_id')->references('id')->on('apps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addresses');
    }
}
