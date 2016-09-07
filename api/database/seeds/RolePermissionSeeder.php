<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rules = array(
            
        );
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleClient = Role::create(['name' => 'client']);
        $user = \App\Models\User::where('email','client@tenposs.com')->first();
        $user->assignRole('admin');


        $permission1 = Permission::create(['name' => 'create clients']);
        $permission2 = Permission::create(['name' => 'update clients']);
        $permission3 = Permission::create(['name' => 'delete clients']);
        $permission4 = Permission::create(['name' => 'create apps']);
        $permission5 = Permission::create(['name' => 'update apps']);
        $permission6 = Permission::create(['name' => 'delete apps']);
        $permission7 = Permission::create(['name' => 'access_backend']);
        $roleAdmin->givePermissionTo($permission1);
        $roleAdmin->givePermissionTo($permission2);
        $roleAdmin->givePermissionTo($permission3);
        $roleAdmin->givePermissionTo($permission4);
        $roleAdmin->givePermissionTo($permission5);
        $roleAdmin->givePermissionTo($permission6);
        $roleAdmin->givePermissionTo($permission7);
        //$user->givePermissionTo($permission7);
    }
}
