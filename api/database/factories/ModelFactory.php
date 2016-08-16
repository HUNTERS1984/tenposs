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
use App\Models\User;
use App\Models\AppUser;
use App\Models\App;
use App\Models\Store;
use App\Models\Address;
use App\Models\AppTopMainImage;
use App\Models\AdminContacts;
use App\Models\Template;
use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\SideMenu;
use App\Models\Menu;
use App\Models\UserProfile;
use App\Models\Coupon;
use App\Models\Item;
use App\Models\Component;
use App\Models\News;
use App\Models\Reserve;

$arrImage = [
    'uploads/1.jpg',
    'uploads/2.jpg'
];

$factory->define(User::class, function (Faker $faker) {
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


$factory->define(AppUser::class, function (Faker $faker) {
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





$factory->define(App::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(array('Shopping App','News App','Restaurants App','Coffee App')),
        'app_app_id' => $faker->md5(32),
        'app_app_secret' => $faker->md5(64),
        'description' => $faker->sentence(20),
        'created_time' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-2 years', $timezone = date_default_timezone_get()),
        'status' => $faker->randomElement(array(0,1,3,4))
    ];
});

$factory->define(Store::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Stores #####')
    ];
});

$factory->define(AppTopMainImage::class, function (Faker $faker) use ($arrImage){
    return [
        'image_url' => $faker->randomElement($arrImage),
    ];
});

$factory->define(Address::class, function (Faker $faker) {
    return [
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180),// 77.147489
        'tel' => $faker->phoneNumber,
        'title' => $faker->streetAddress,
        'start_time' => $faker->unixTime($max = 'now'),
        'end_time' => $faker->unixTime($max = 'now')
    ];
});

$factory->define(AdminContacts::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'name' => $faker->name,
        'message' => $faker->sentence(20)
    ];
});


$factory->define(Template::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Template #####'),
    ];
});


$factory->define(PhotoCat::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Photo Category #####'),
    ];
});

$factory->define(Photo::class, function (Faker $faker) use ($arrImage) {
    return [
        'image_url' => $faker->randomElement($arrImage),
    ];
});

$factory->define(SideMenu::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Slide Menu #####'),
    ];
});

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Menu #####'),
    ];
});


$factory->define(UserProfile::class, function (Faker $faker) use ($arrImage){
    return [
        'name' => $faker->firstName.' '.$faker->lastName,
        'gender' => $faker->randomElement(['Male','Female']),
        'address' => $faker->address,
        'avatar_url' => $faker->randomElement($arrImage),
    ];
});

$factory->define(Coupon::class, function (Faker $faker) use ($arrImage) {
    return [
        'type' =>  $faker->randomElement(array(0,1,3,4)),
        'title' => $faker->numerify('Coupon #####'),
        'description' => $faker->sentence(10),
        'start_date' => date($format = 'Y-m-d H:s:i'),
        'end_date' => date($format = 'Y-m-d H:s:i'),
        'status' => $faker->randomElement(array(0,1,3,4)),
        'image_url' => $faker->randomElement($arrImage),
        'limit' => 50
    ];
});


$factory->define(Item::class, function (Faker $faker) use($arrImage) {
    return [
        'title' => $faker->numerify('Coupon #####'),
        'price' => 10000,
        'image_url' => $faker->randomElement($arrImage),
        'description' => $faker->sentence(10),
    ];
});

$factory->define(Component::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Components #####'),
    ];
});

$factory->define(News::class, function (Faker $faker) use($arrImage) {
    return [
        'title' => $faker->sentence(7),
        'description' => $faker->sentence(20),
        'image_url' => $faker->randomElement($arrImage),
        'date' => $faker->date('Y-m-d H:s:i'),
    ];
});


$factory->define(Reserve::class, function (Faker $faker) use($arrImage) {
    return [
        'reserve_url' => $faker->url,
    ];
});

