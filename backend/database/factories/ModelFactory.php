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
use App\Models\News;
use App\Models\Coupon;
use App\Models\Item;


$factory->define(App\Models\Store::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Stores #####')
    ];
});

$factory->define(App\Models\Address::class, function (Faker $faker) {
    return [
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180),// 77.147489
        'tel' => $faker->phoneNumber,
        'title' => $faker->streetAddress,
        'start_time' => $faker->unixTime($max = 'now'),
        'end_time' => $faker->unixTime($max = 'now')
    ];
});


$factory->define(App\Models\PhotoCat::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Photo Category #####'),
    ];
});

$factory->define(App\Models\Photo::class, function (Faker $faker) {
    return [
        'image_url' => $faker->imageUrl($width = 800, $height = 800, 'cats'),
    ];
});


$factory->define(App\Models\News::class, function(Faker $faker){
    return [
        'title'=>$faker->numerify('News ###'),
        'description'=>$faker->sentence(10),
        'date' => date($format = 'Y-m-d H:s:i'),
        'image_url'=> $faker->imageUrl(300,300,'cats')
    ];
});

$factory->define(Coupon::class,function(Faker $faker){
    return [
        'type' =>  $faker->randomElement(array(0,1,3,4)),
        'title' => $faker->numerify('Coupon #####'),
        'description' => $faker->sentence(10),
        'start_date' => date($format = 'Y-m-d H:s:i'),
        'end_date' => date($format = 'Y-m-d H:s:i'),
        'status' => $faker->randomElement(array(0,1,3,4)),
        'image_url' => $faker->imageUrl(300,300,'cats'),
        'limit' => 50
    ];
});

$factory->define(App\Models\Menus::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Menu #####'),
    ];
});

$factory->define(App\Models\Item::class, function (Faker $faker) {
    return [
        'title' => $faker->numerify('Item #####'),
        'price' => 10000,
        'image_url' => $faker->imageUrl(300,300,'cats'),
        'description' => $faker->sentence(10),
    ];
});
