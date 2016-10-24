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
    	'blogs',
    	'faqs',
    	'news',
    	'intergrations',
    	'introduction_types',
    	'introduction_cases',
    	'start_guides',
    	'partnerships'
    ];
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
        if (DB::connection()->getName() === 'mysql') {
            $this->truncateDatabase();
        }
        $this->call(BlogTableSeeder::class);
        $this->call(FaqTypeTableSeeder::class);
        $this->call(IntergrationTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(PartnershipTableSeeder::class);
        $this->call(StartguideTableSeeder::class);
        $this->call(IntrotypeTableSeeder::class);
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
