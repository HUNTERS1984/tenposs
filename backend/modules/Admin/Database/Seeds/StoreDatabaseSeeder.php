<?php
namespace Modules\Admin\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Models\Stores;
use App\Models\StoreTopMainImages;
use App\Models\Addresses;
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
        factory(Stores::class, 10)->create()
            ->each(function ($store) {
                $store->address()->saveMany(factory(Addresses::class,2)->make());
                $store->store_top_main_image()->saveMany(factory(StoreTopMainImages::class,2)->make());
                $store->news()->saveMany(factory(News::class,10)->make());
            });
    }
}
