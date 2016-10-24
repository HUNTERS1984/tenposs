<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->string('slug');
            $table->string('answer');
            $table->boolean('status')->default('1');
            $table->integer('order');
            $table->integer('view')->default('0');
            $table->integer('faqtype_id')->unsigned();
            $table->foreign('faqtype_id')->references('id')->on('faqtypes')->onDelete('cascade');
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
        Schema::drop('faqs');
    }
}
