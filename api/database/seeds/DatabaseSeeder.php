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
        'addresses','admin_contacts','apps','app_settings','app_stores','app_top_main_images',
        'app_users','components','coupons','items','menus','news','photos','photo_categories',
        'rel_apps_stores','rel_app_settings_components','rel_app_settings_sidemenus','rel_items',
        'rel_menus_items','reserves','sidemenus','stores','templates','users','user_messages',
        'user_profiles','user_pushs','user_sessions','roles','permissions','role_has_permissions',
        'user_has_permissions','user_has_roles'


    ];

    /**
     * Seeder classes.
     *
     * @var array
     */
    protected $seeders = [
        UsersTableSeeder::class,
        RolePermissionSeeder::class
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
