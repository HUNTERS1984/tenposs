<?php

use Illuminate\Database\Seeder;
use App\Models\Components;
use App\Models\AppSetting;
use Illuminate\Support\Facades\DB;

class Components_RelAppSettingComponents extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Components::class, 10)
            ->create()
            ->each(function( $component ){
                AppSetting::all()
                    ->each(function($appsetting) use ($component){
                        DB::table('rel_app_settings_components')->insert(
                            [
                                'app_setting_id' => $appsetting->id,
                                'component_id' => $component->id
                            ]
                        );
                    });
            });
    }
}
