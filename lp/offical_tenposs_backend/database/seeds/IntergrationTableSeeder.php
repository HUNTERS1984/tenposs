<?php

use Illuminate\Database\Seeder;

class IntergrationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Intergration::class,8)->create();
    }
}
