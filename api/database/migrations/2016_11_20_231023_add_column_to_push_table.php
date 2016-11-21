<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPushTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pushes', function ($table) {
            $table->timestamp('time_regular')->nullable();
            $table->string('time_regular_string')->nullable();
            $table->integer('time_count_repeat')->nullable();
            $table->integer('time_count_delivered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pushes', function($table) {
            $table->dropColumn('time_regular');
            $table->dropColumn('time_regular_string');
            $table->dropColumn('time_count_repeat');
            $table->dropColumn('time_count_delivered');
        });
    }
}
