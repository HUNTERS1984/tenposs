<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('coupons') ){
            Schema::create('coupons', function (Blueprint $table) {
                $table->integer('id',10)->unsigned();
                $table->smallInteger('type',4)->nullable();
                $table->string('title',255)->nullable();
                $table->text('description')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->smallInteger('status',false);
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
                $table->timestamp('deleted_at');
                $table->integer('app_id',false)->unsigned();
                $table->string('image_url',255)->nullable();
                $table->integer('limit',false)->nullable();
                $table->primary(['id','app_id']);

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
        Schema::drop('coupons');
    }
}
