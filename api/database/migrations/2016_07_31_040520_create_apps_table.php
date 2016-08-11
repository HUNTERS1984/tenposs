<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('apps') ){
            Schema::create('apps', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',255)->nullable();
                $table->text('description')->nullable();
                $table->timestamp('created_time')->nullable();
                $table->smallInteger('status',false)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
                $table->integer('user_id',false)->unsigned();

                $table->index(['user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apps');
    }
}
