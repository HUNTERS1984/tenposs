<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShareCodeInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_code_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->integer('app_id', false)->unsigned()->nullable();
            $table->string('app_uuid')->nullable();
            $table->string('email')->nullable();
            $table->smallInteger('status', false)->default(0); //1 used
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('share_code_info');
    }
}
