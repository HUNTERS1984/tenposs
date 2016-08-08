<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasTable('components') ){
            Schema::create('components', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name',255)->nullable();
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
                $table->timestamp('deleted_at');
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
        Schema::dropIfExists('components');
    }
}
