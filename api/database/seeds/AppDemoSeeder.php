<?php

use Illuminate\Database\Seeder;


use App\Models\AppUser;
use App\Models\Apps;
use App\Models\User;
class AppDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $user = User::where('email','client@tenposs.com')->first();
        $app = new Apps();
        $app->name = 'Nhien App';
        $app->description = 'Nhien Test App';
        $app->line_channel_id = '1477592731';
        $app->line_channel_secret = '789ac444af36a5020a5b4c74a9455f5f';
        $app->bot_channel_id = '1476076743';
        $app->bot_channel_secret = 'c3b5f65446faefcf1471609353cc943c';
        $app->bot_mid = 'uaa357d613605ebf36f6366a7ce896180';
        $app->status = '1';
        $app->user_id = $user->id;
        $app->save();
        
        $appuser = new AppUser();
        $appuser->email = "phanvannhien@gmail.com";
        $appuser->password = bcrypt("123456");
        $appuser->app_id = $app->id;
        $appuser->role = "1";
        $appuser->save();
        
    }
}