<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntroductionCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introduction_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('img_url');
            $table->string('img_alt');
            $table->boolean('status')->default('1');
            $table->integer('order');
            $table->integer('view')->default('0');
            $table->integer('intro_type_id')->unsigned();
            $table->foreign('intro_type_id')->references('id')->on('introduction_types')->onDelete('cascade');
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
        Schema::drop('introduction_cases');
    }
}
