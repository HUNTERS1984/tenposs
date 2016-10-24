<?php

use Illuminate\Database\Seeder;

class StartguideTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Startguide::class,8)->create();
    }
}
