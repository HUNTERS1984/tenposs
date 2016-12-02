<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_users', function($table) {
            $table->dropColumn('email');
            $table->dropColumn('password');
            $table->dropColumn('social_type');
            $table->dropColumn('social_id');
            $table->dropColumn('role');
            $table->dropColumn('android_push_key');
            $table->dropColumn('apple_push_key');
            $table->dropColumn('web_push_key');
            $table->dropColumn('temporary_hash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_users', function ($table) {
            $table->string('email',100);
            $table->string('password',60);
            $table->smallInteger('social_type');
            $table->string('social_id');
            $table->string('temporary_hash',60);
            $table->string('android_push_key');
            $table->string('apple_push_key');
            $table->smallInteger('role');
            $table->string('web_push_key');
        });
    }
}
