<?php

use Illuminate\Database\Seeder;
use App\Models\Stores;
use App\Models\StoreTopMainImages;

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
                
                $store->store_top_main_image()->saveMany(factory(StoreTopMainImages::class),2)->make();
            });
    }
}
