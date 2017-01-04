<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSegmentToPushTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pushes', function ($table) {
            $table->boolean('segment_all_user')->nullable();
            $table->boolean('segment_active_user')->nullable();
            $table->boolean('segment_inactive_user')->nullable();
            $table->boolean('segment_a_user')->nullable();
            $table->timestamp('time_selected')->nullable();
            $table->string('time_selected_string',100)->nullable();
            $table->string('time_selected_type',50)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pushes', function ($table) {
            $table->dropColumn('segment_all_user');
            $table->dropColumn('segment_active_user');
            $table->dropColumn('segment_inactive_user');
            $table->dropColumn('segment_a_user');
            $table->dropColumn('time_selected');
            $table->dropColumn('time_selected_string');
            $table->dropColumn('time_selected_type');
        });
    }
}
