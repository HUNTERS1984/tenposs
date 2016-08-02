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
            $table->string('email',100);
            $table->string('password',60);
            $table->string('fullname',100)->nullable();
            $table->unsignedInteger('sex',false);
            $table->date('birthday',60);
            $table->string('locale',5)->nullable();
            $table->unsignedInteger('status',false)->default(0);
            $table->string('temporary_hash',60);
            $table->rememberToken();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
           // $table->timestamps();
            $table->string('company',255)->nullable();
            $table->string('string',255)->nullable();
            $table->string('tel',20)->nullable();

            $table->unique('email');
            $table->index('tel');
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
