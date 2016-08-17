<?php

use Illuminate\Database\Seeder;

use App\Models\AdminContacts;

class AdminContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(AdminContacts::class, 10)->create();
    }
}
