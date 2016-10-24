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

// $factory->define(App\User::class, function (Faker\Generator $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->safeEmail,
//         'password' => bcrypt(str_random(10)),
//         'remember_token' => str_random(10),
//     ];
// });

$factory->define(App\Models\Blog::class, function (Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content'=>$faker->paragraph(),
		'img_url'=>$faker->imageUrl('150','150'),
		'status' => 1,
		'view' => 0,
	];
});

$factory->define(App\Models\FaqType::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
	];
});

$factory->define(App\Models\Faq::class, function(Faker\Generator $faker){
	return [
		'question' => $faker->sentence(),
		'answer' => $faker->sentence(),
		'status' => 1,
		'view' => 0,
	];
});

$factory->define(App\Models\Intergration::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'img_url'=>$faker->imageUrl('150','150'),
		'status' => 1,
		'view' => 0,
	];
});

$factory->define(App\Models\Introduction_type::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'status' => 1,
	];
});

$factory->define(App\Models\Introduction_case::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'img_url'=>$faker->imageUrl('150','150'),
		'status' => 1,
		'view' => 0,
	];
});

$factory->define(App\Models\News::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'img_url'=>$faker->imageUrl('150','150'),
		'status' => 1,
		'view' => 0,
	];
});

$factory->define(App\Models\Partnership::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'img_url'=>$faker->imageUrl('150','150'),
		'status' => 1,
		'view' => 0,
	];
});

$factory->define(App\Models\Startguide::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->sentence(),
		'content' => $faker->paragraph(),
		'img_url'=>$faker->imageUrl('150','150'),
		'status' => 1,
		'view' => 0,
	];
});