<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $tables = [
        'apps',
        'stores',
        'photo_categories',
        'photos',
        'menus',
        'news',
        'coupons',
        'items',

    ];

    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
        if (DB::connection()->getName() === 'mysql') {
            $this->truncateDatabase();
        }
        $this->call(StoreTableSeeder::class);
        Model::reguard();
    }

    public function truncateDatabase(){
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    	foreach($this->tables as $table){
    		DB::table($table)->truncate();
    	}
    	DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
