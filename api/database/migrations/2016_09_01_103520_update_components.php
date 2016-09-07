<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('components',function($table){
            $table->string('top')->after('name')->nullable();;
            $table->string('sidemenu')->after('top')->nullable();;
            $table->smallInteger('viewmore')->after('sidemenu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('top');
            $table->dropColumn('sidemenu');
            $table->dropColumn('viewmore');
        });
    }
}
