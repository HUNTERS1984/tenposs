<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppNameBussinesTypeToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function($table) {
            $table->string('business_type',100)->nullable();
            $table->string('app_name_register',255)->nullable();
            $table->string('fax',255)->nullable();
            $table->string('domain',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('business_type');
            $table->dropColumn('app_name_register');
            $table->dropColumn('fax');
            $table->dropColumn('domain');
        });
    }
}
