<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('point_setting', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('app_app_id');
            $table->string('yen_to_mile')->nullable();
            $table->string('mile_to_point')->nullable();
            $table->timestamps();
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
        Schema::drop('point_setting');
    }
}
