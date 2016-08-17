<?php

use Illuminate\Database\Seeder;
use App\Models\Coupons;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Coupons::all()
            ->each(function($c){
                $c->items()->saveMany(factory(\App\Models\Items::class, 5)->make());
                // rel_menus_items
            });
    }
}
