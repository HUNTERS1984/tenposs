<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20);
            $table->string('email',100)->unique();
            $table->string('password',60);
            $table->string('fullname',100);
            $table->smallInteger('sex',4);
            $table->date('birthday',60);
            $table->string('locale',5);
            $table->smallInteger('status',4)->default(0);
            $table->string('temporary_hash',60);
            $table->rememberToken();
            $table->timestamps();
            $table->string('company',255);
            $table->string('string',255);
            $table->string('tel',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
