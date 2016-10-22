<?php

use Illuminate\Database\Seeder;

class IntrotypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Introduction_type::class,8)->create()
        	->each(function($introtype){
        		$introtype->intro_cases()->saveMany(factory(App\Models\Introduction_case::class,2)->make());
        	});
    }
}
