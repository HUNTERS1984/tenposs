<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Tables for seeding data.
     *
     * @var array
     */
    protected $tables = [
        'users',
        'apps',
        'stores',
        'app_top_main_images',
        'admin_contacts',
        'templates',
        'sidemenus',
        'app_settings',
        'rel_app_settings_sidemenus'
    ];

    /**
     * Seeder classes.
     *
     * @var array
     */
    protected $seeders = [
        UsersTableSeeder::class,
        SlideMenuSeeder::class
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
        if (DB::connection()->getName() === 'mysql') {
            $this->truncateDatabase();
        }
        foreach ($this->seeders as $seeder) {
            $this->call($seeder);
        }
        Model::reguard();
    }
    /**
     * Truncate the database.
     */
    private function truncateDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
