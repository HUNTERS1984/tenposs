<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTableActivation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if( !Schema::hasTable('user_activations') )
            Schema::create('user_activations', function (Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->string('token')->index();
                $table->timestamp('created_at');
            });
        if (Schema::hasTable('users')) {
            
            if ( ! Schema::hasColumn('users','activated')) {
                //
                Schema::table('users', function ($tableUsers) {
                    $tableUsers->boolean('activated')->default(false);
                });
            }
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
