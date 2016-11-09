<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@hunters.com',
            'password' => app('hash')->make('mq123456'),
            'remember_token' => str_random(10),
        ]);

        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => '', // optional
            'level' => 1,
        ]);


//        $user->attachRole($adminRole);

        Role::create([
            'name' => 'Client',
            'slug' => 'client',
            'description' => '', // optional
            'level' => 2,
        ]);

        Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => '', // optional
            'level' => 3,
        ]);

        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => '', // optional
            'level' => 4,
        ]);
    }
}
