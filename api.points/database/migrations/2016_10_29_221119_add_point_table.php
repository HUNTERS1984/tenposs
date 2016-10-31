<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('points', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('auth_user_id')->unique();;
            $table->string('app_app_id');
            $table->integer('points')->nullable();
            $table->integer('miles')->nullable();
            $table->smallInteger('active')->default(0);
            $table->timestamps();
            $table->index('auth_user_id');
            $table->index('app_app_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('points');
    }
}
