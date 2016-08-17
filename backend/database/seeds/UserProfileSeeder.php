<?php

use Illuminate\Database\Seeder;
use App\Models\AppUsers;


class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AppUsers::all()
            ->each(function($appuser){
                $appuser->user_profiles()->saveMany(factory(\App\Models\UserProfiles::class, 2)->make());
            });

    }
}
