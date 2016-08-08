<?php

use Illuminate\Database\Seeder;
use App\Models\Stores;
use App\Models\StoreTopMainImages;
use App\Models\Addresses;
use App\Models\PhotoCategories;
use App\Models\Photos;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Stores::class, 10)->create()
            ->each(function ($store) {
                $store->address()->saveMany(factory(Addresses::class,2)->make());
                $store->store_top_main_image()->saveMany(factory(StoreTopMainImages::class,2)->make());
                // photo category

                factory(PhotoCategories::class, 3)->create()
                    ->each(function ($category){
                        $category->photo()->saveMany(factory(Photos::class,9)->make());
                    });



            });
    }
}
