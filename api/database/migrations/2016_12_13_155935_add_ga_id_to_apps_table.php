<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGaIdToAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function ($table) {
            $table->string('mobile_ga_id');
            $table->string('web_ga_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apps', function ($table) {
            $table->dropColumn('mobile_ga_id');
            $table->dropColumn('web_ga_id');
        });
    }
}
