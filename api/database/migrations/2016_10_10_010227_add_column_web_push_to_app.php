<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnWebPushToApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function ($table) {
            $table->string('web_push_server_key')->nullable();
            $table->string('web_push_sender_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apps', function($table) {
            $table->dropColumn('web_push_server_key');
            $table->dropColumn('web_push_sender_id');
        });
    }
}
