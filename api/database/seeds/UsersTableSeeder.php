<?php

use Illuminate\Database\Seeder;
use App\Models\Users;
use App\Models\Apps;
use App\Models\Templates;
use App\Models\PhotoCategories;
use App\Models\Photos;
use App\Models\Addresses;
use App\Models\AppTopMainImages;
use App\Models\Stores;
use App\Models\Coupons;


use Faker\Generator as Faker;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create users clients => apps
        factory(Users::class, 5)
            ->create()
            ->each(function ($user) {
                // Create apps for per user
                $user->apps()->saveMany(factory(Apps::class, 2)->make());
            });

        // Create users apps => stores
        Apps::all()
            ->each(function ($app) {
                // apps has many stores, stores has many addresses
                $app->stores()->saveMany(factory(Stores::class, 2)->make());
                $app->app_top_main_images()->saveMany(factory(AppTopMainImages::class,2)->make());

                factory(Templates::class,2)->create()
                    ->each(function($template) use($app){
                        $faker = \Faker\Factory::create();

                        $app->templates()->sync([$app->id => array(
                            'title' => $faker->title,
                            'title_color' => $faker->hexColor,
                            'font_size' => $faker->randomElement(array('12','13','14')),
                            'font_family' => $faker->randomElement(array('Arial','Tahoma')),
                            'header_color' => $faker->hexColor,
                            'menu_icon_color' => $faker->hexColor,
                            'menu_background_color' => $faker->hexColor,
                            'menu_font_color' => $faker->hexColor,
                            'menu_font_size' => $faker->randomElement(array('12','13','14')),
                            'menu_font_family' => $faker->randomElement(array('Arial','Tahoma')),
                            'top_main_image_url' => $faker->imageUrl(800,600,'cats')
                        )]);
                    });

                // Create app_users
                $app->app_users()->saveMany(factory(\App\Models\AppUsers::class, 2)->make());


            });

        Stores::all()
            ->each(function($store){
                $store->address()->saveMany(factory(Addresses::class,2)->make());
                $store->photo_categories( factory(PhotoCategories::class, 3)->make());
                $store->coupons( factory(Coupons::class, 5)->make());
                
            });

        PhotoCategories::all()
            ->each(function($category){
                $category->photo()->saveMany(factory(Photos::class,9)->make());

            });








    }
}
