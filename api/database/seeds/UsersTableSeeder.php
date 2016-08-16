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
use App\Models\News;
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
        $faker = \Faker\Factory::create();
        $arrImage = [
            'uploads/1.jpg',
            'uploads/2.jpg'
        ];

        // Create users clients => apps
        factory(User::class, 5)
            ->create()
            ->each(function ($user) {
                // Create apps for per user
                $user->apps()->saveMany(factory(App::class, 2)->make());
            });

        User::create(
            [
                'name' => $faker->name,
                'email' => 'client@tenposs.com',
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
            ]
        );

        // Create users apps => stores
        App::all()
            ->each(function ($app) {
                // apps has many stores, stores has many addresses
                $app->stores()->saveMany( factory(Store::class, 2)->make() );
                // Create app_users
                $app->app_users()->saveMany(factory(\App\Models\AppUser::class, 2)->make());
            });


        factory(Template::class,10)->create();

        $i = 1;
        foreach (Template::all() as $temp){

            $faker = \Faker\Factory::create();
            DB::table('app_settings')->insert([
                'app_id' => App::find($i)->id,
                'template_id' => $temp->id,
                'title' => $faker->numerify('Setting #####'),
                'title_color' => $faker->hexColor,
                'font_size' => $faker->randomElement(array('12', '13', '14')),
                'font_family' => $faker->randomElement(array('Arial', 'Tahoma')),
                'header_color' => $faker->hexColor,
                'menu_icon_color' => $faker->hexColor,
                'menu_background_color' => $faker->hexColor,
                'menu_font_color' => $faker->hexColor,
                'menu_font_size' => $faker->randomElement(array('12', '13', '14')),
                'menu_font_family' => $faker->randomElement(array('Arial', 'Tahoma')),
                'top_main_image_url' => $faker->randomElement($arrImage),
            ]);

            $i++;
        }



        Store::all()
            ->each(function($store){
                $store->addresses()->saveMany( factory(Address::class,2)->make() );
                $store->photo_cats()->saveMany( factory(PhotoCat::class, 3)->make() );
                $store->coupons()->saveMany( factory(Coupon::class, 5)->make() );
                $store->menus()->saveMany(factory(\App\Models\Menu::class, 5)->make());
                $store->reserves()->saveMany(factory(\App\Models\Reserve::class, 5)->make());
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


        $arrComponents = [
            'Top Slideshow',
            'Recently',
            'News',
            'Contact',
            'Photo Gallery'
        ];

        foreach ($arrComponents as $item){
            Component::create(['name' => $item]);
        }


        Component::all()
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
        //factory(SideMenu::class, 20)->create();
        $arraySlideMenus = [
            'Home',
            'Menu',
            'Reserve',
            'News',
            'Photo Gallery',
            'Staff',
            'Coupon',
            'Chat',
            'Setting'
        ];

        foreach ($arraySlideMenus as $item){
            SideMenu::create(['name' => $item]);
        }

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

        AppSetting::all()
            ->each(function($set){
                $set->images()->saveMany(factory(\App\Models\TopMainImage::class,2));
            });

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

        // Feed news
        Store::all()
            ->each(function($store){
                $store->news()->saveMany(factory(News::class,10)->make());
            });
    }
}
