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
use App\Models\AdminContacts;


$factory->define(App\Models\AppUsers::class, function (Faker $faker) {
    return [
        'email' => $faker->safeEmail,
        'password' => bcrypt('123456'), // default password
        'social_type' => $faker->randomElement(array(0,1,3,4)),
        'social_id' => $faker->sha1,
        'temporary_hash' => $faker->sha256,
        'android_push_key' => $faker->sha256,
        'apple_push_key' => $faker->sha256,
        'temporary_hash' => $faker->sha256,
        'role' => $faker->randomElement(array(0,1,3,4)),
    ];
});




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

$factory->define(App\Models\Stores::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Stores #####')
    ];
});

$factory->define(App\Models\AppTopMainImages::class, function (Faker $faker) {
    return [
        'image_url' => $faker->imageUrl($width = 800, $height = 400, 'cats'),
    ];
});

$factory->define(App\Models\Addresses::class, function (Faker $faker) {
    return [
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180),// 77.147489
        'tel' => $faker->phoneNumber,
        'title' => $faker->streetAddress,
        'start_time' => $faker->unixTime($max = 'now'),
        'end_time' => $faker->unixTime($max = 'now')
    ];
});

$factory->define(App\Models\AdminContacts::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'name' => $faker->name,
        'message' => $faker->sentence(20)
    ];
});


$factory->define(App\Models\Templates::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Template #####'),
    ];
});


$factory->define(App\Models\PhotoCategories::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Photo Category #####'),
    ];
});

$factory->define(App\Models\Photos::class, function (Faker $faker) {
    return [
        'image_url' => $faker->imageUrl($width = 800, $height = 800, 'cats'),
    ];
});

$factory->define(App\Models\SlideMenus::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Menu #####'),
    ];
});


