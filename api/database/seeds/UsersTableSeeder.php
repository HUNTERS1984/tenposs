<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AppUser;
use App\Models\App;
use App\Models\AppSetting;
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
        factory(User::class, 5)
            ->create()
            ->each(function ($user) {
                // Create apps for per user
                $user->apps()->saveMany(factory(App::class, 2)->make());
            });

        // Create users apps => stores
        App::all()
            ->each(function ($app) {
                // apps has many stores, stores has many addresses
                $app->stores()->saveMany( factory(Store::class, 2)->make() );
                $app->app_top_main_images()->saveMany( factory(AppTopMainImage::class,2)->make() );
                // Create app_users
                $app->app_users()->saveMany(factory(\App\Models\AppUser::class, 2)->make());
            });


        factory(Template::class,5)->create();

        Template::skip(1)->take(2)->get()
            ->each(function($template){

                App::skip(1)->take(2)->get()
                    ->each(function($app) use ($template){
                        $faker = \Faker\Factory::create();
                        DB::table('app_settings')->insert([
                            'app_id' => $app->id,
                            'template_id' => $template->id,
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
                        ]);
                    });

            });

        Store::all()
            ->each(function($store){
                $store->addresses()->saveMany( factory(Address::class,2)->make() );
                $store->photo_cats()->saveMany( factory(PhotoCat::class, 3)->make() );
                $store->coupons()->saveMany( factory(Coupon::class, 5)->make() );
                $store->menus()->saveMany(factory(\App\Models\Menu::class, 5)->make());
            });

        PhotoCat::all()
            ->each(function($category){
                $category->photo()->saveMany(factory(Photo::class,9)->make());
            });


        //
        AppUser::all()
            ->each(function($appuser){
                $appuser->profile()->saveMany(factory(\App\Models\UserProfile::class, 2)->make());
            });

        factory(AdminContacts::class, 10)->create();


        factory(Component::class, 10)
            ->create()
            ->each(function( $component ){
                AppSetting::all()
                    ->each(function($appsetting) use ($component){
                        DB::table('rel_app_settings_components')->insert(
                            [
                                'app_setting_id' => $appsetting->id,
                                'component_id' => $component->id
                            ]
                        );
                    });
            });

        //
        factory(SideMenu::class, 20)->create();

        $setting = DB::table('app_settings')->get();
        foreach ($setting as $set){
            SideMenu::all()
                ->each(function($slidemenu, $i = 0) use ($set){
                    DB::table('rel_app_settings_sidemenus')->insert([
                        'app_setting_id' => $set->id,
                        'sidemenu_id' => $slidemenu->id,
                        'order' => $i
                    ]);
                    $i++;
                });
        }

        //
        Coupon::all()
            ->each(function($c){
                $c->items()->saveMany(factory(\App\Models\Item::class, 5)->make());
                // rel_menus_items
            });

        Item::skip(1)->take(2)->get()
            ->each(function($items){
                // Create relmenusitems
                Menu::skip(1)->take(2)->get()
                    ->each(function($menu) use ($items){

                        DB::table('rel_menus_items')->insert([
                            'menu_id' => $menu->id,
                            'item_id' => $items->id
                        ]);
                    });
                // rel_items
                Item::skip(1)->take(2)->get()
                    ->each(function($items_relation) use ($items){
                        if( $items->id != $items_relation->id ){
                            DB::table('rel_items')->insert([
                                'item_id' => $items->id,
                                'related_id' => $items_relation->id
                            ]);
                        }
                    });


            });


    }
}
