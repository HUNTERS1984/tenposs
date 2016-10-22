<?php

use Illuminate\Database\Seeder;

class PartnershipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Partnership::class,8)->create();
    }
}
