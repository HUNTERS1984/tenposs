<?php

use Illuminate\Database\Seeder;
use App\Models\Items;
use App\Models\Menus;
use Illuminate\Support\Facades\DB;

class RelMenuItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Items::skip(1)->take(2)->get()
            ->each(function($items){
                // Create relmenusitems
                Menus::skip(1)->take(2)->get()
                    ->each(function($menu) use ($items){

                        DB::table('rel_menus_items')->insert([
                            'menu_id' => $menu->id,
                            'item_id' => $items->id
                        ]);
                    });
                // rel_items
                Items::skip(1)->take(2)->get()
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
