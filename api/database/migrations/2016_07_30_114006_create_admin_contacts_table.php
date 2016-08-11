<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_contacts', function (Blueprint $table) {
            $table->increments('id');// included increments and unsigned and not null end primary key
            $table->string('email',100);
            $table->string('name',255);
            $table->text('message');
            $table->timestamps();

            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_contacts');
    }
}
