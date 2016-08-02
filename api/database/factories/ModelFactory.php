<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Faker\Generator as Faker;
use App\Models\Users;
use App\Models\AppUsers;
use App\Models\UserProfiles;
use App\Models\Apps;




$factory->define(App\Models\Users::class, function (Faker $faker) {
    return [

        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('123456'), // default password
        'fullname' => $faker->name,
        'sex' => $faker->randomElement(array(0,1)),
        'birthday' => $faker->dateTimeBetween($startDate = '-60 years', $endDate = '-18 years', $timezone = date_default_timezone_get()), // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
        'locale' => $faker->locale,
        'status' => $faker->randomElement(array(0,1,3,4)),
        'temporary_hash' => md5(32),
        'remember_token' => '',
        'company' => $faker->company,
        'address' => $faker->address,
        'tel' => $faker->phoneNumber
    ];
});

$factory->define(App\Models\Apps::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(array('Shopping App','News App','Restaurants App','Coffee App')),
        'description' => $faker->sentence(20),
        'created_time' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-2 years', $timezone = date_default_timezone_get()),
        'status' => $faker->randomElement(array(0,1,3,4))
    ];
});
