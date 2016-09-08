<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('line_channel_id',255)->nullable();
            $table->string('line_channel_secret',255)->nullable();
            $table->string('bot_channel_id',255)->nullable();
            $table->string('bot_channel_secret',255)->nullable();
            $table->string('displayName',255)->nullable();
            $table->string('pictureUrl',255)->nullable();
            $table->string('statusMessage',255)->nullable();
            $table->string('bot_mid',255)->nullable();
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('configurations');
    }
}