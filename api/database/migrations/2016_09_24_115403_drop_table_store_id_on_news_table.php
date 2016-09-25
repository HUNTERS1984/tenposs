<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableStoreIdOnNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign('news_store_id_foreign');
            $table->dropColumn('store_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->integer('store_id',false)->unsigned()->nullable();
            $table->index('store_id');
            $table->foreign('store_id')->references('id')->on('stores');
        });
    }
}
