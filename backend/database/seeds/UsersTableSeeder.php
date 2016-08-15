<?php

use Illuminate\Database\Seeder;
use App\Models\Users;
use App\Models\Apps;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create users
        factory(Users::class, 50)->create()
            ->each(function ($user) {
                // Create app for per user
                $user->apps()->saveMany(factory(Apps::class),2)->make();
            });
    }
}
