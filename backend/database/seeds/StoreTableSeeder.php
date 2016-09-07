<?php

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\StoreTopMainImages;
use App\Models\Address;
use App\Models\PhotoCat;
use App\Models\Photo;
use App\Models\News;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Store::class,5)->create()
            ->each(function($store){
                 // $store->addresses()->saveMany(factory(Address::class,2)->make());
                 $store->news()->saveMany(factory(News::class,2)->make());
                 $store->menus()->saveMany(factory(App\Models\Menus::class,2)->make());
                 // $store->store_top_main_image()->saveMany(factory(StoreTopMainImages::class,2)->make());

                 factory(PhotoCat::class,1)->create()->each(function($photocat){
                    $photocat->photo()->saveMany(factory(Photo::class,2)->make());
                 });

                 factory(App\Models\Coupon::class,1)->create()->each(function($coupon){
                    $coupon->items()->saveMany(factory(App\Models\Item::class,2)->make());
                 });
            });
    }
}
