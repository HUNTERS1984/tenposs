    <?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Models\SlideMenus::class, 20)->create();

        $setting = DB::table('app_settings')->get();
        foreach ($setting as $set){
            \App\Models\SlideMenus::all()
                ->each(function($slidemenu, $i = 0) use ($set){
                    DB::table('rel_app_settings_sidemenus')->insert([
                        'app_setting_id' => $set->id,
                        'sidemenu_id' => $slidemenu->id,
                        'order' => $i
                    ]);
                    $i++;
                });
        }
    }
}
