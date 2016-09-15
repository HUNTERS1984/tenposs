<?php

namespace App\Models;
use Carbon\Carbon;
use Hash;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    const STATUS_TEMPORARY = 0;
    const STATUS_VALID = 1;
    const STATUS_INVALID = 9;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fullname', 'status', 'temporary_hash', 'sex', 'birthday', 'locale', 'company', 'address', 'tel'
    ];
    protected $table = 'users';

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required|email'
        //...
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function contacts(){
        return $this->hasMany(Contact::class);

    }
    public static function createAsTemporary(array $data)
    {
        $data['temporary_hash'] = self::createTemporaryHash($data);
        $data['status'] = self::STATUS_TEMPORARY;

        return self::create($data);
    }
    public static function createTemporaryHash(array $data)
    {
        $hash = Hash::make(
            $data['name'] . $data['password'] . Carbon::now()->timestamp
        );

        return $hash;
    }

    /**
     * Find by temporary hash
     *
     * @var string $hash temporary_hash
     * @return User
     */
    public static function findByTemporaryHash($hash)
    {
        return self::where('temporary_hash', $hash)->first();
    }

    // Users has many apps
    public function apps(){
        return $this->hasMany(App::class);
    }
    
    public function createAppSettingDefault(){
        

        $app = new \App\Models\App;
        $app->name = $this->app_name_register;
        $app->app_app_id = md5(uniqid(rand(), true));
        $app->app_app_secret = md5(uniqid(rand(), true));
        $app->description =  'なし';
        $app->status = 1;
        $app->business_type = $this->business_type;
        $app->user_id = $this->id;
        $app->save();
          
        $templateDefaultID = 1;
    
        $appSetting = new \App\Models\AppSetting;
        $appSetting->app_id = $app->id;
        $appSetting->title = 'Default';
        $appSetting->title_color = '#b2d5ef';
        $appSetting->font_size = '12';
        $appSetting->font_family = 'Arial';
        $appSetting->header_color = '#aee30d';
        $appSetting->menu_icon_color = '#eb836f';
        $appSetting->menu_background_color = '#5a15ee';
        $appSetting->menu_font_color = '#5ad29f';
        $appSetting->menu_font_size = '12';
        $appSetting->menu_font_family = 'Tahoma';
        $appSetting->template_id = $templateDefaultID;
        $appSetting->top_main_image_url = 'uploads/1.jpg';
        $appSetting->app_top_main_images = 'uploads/1.jpg';
        $appSetting->save();
       
        
        \App\Models\Component::all()
            ->each( function( $component ){
                DB::table('rel_app_settings_components')->insert(
                    [
                        'app_setting_id' => $appSetting->id,
                        'component_id' => $component->id
                    ]
                );
            } );
            
        \App\Models\SideMenu::all()
            ->each( function( $menu ){
                DB::table('rel_app_settings_sidemenus')->insert([
                    'app_setting_id' => $appSetting->id,
                    'sidemenu_id' => $menu->id,
                    'order' => 1
                ]);
            } );    
        
        DB::table('app_top_main_images')->insert([
            'app_setting_id' => $appSetting->id,
            'image_url' =>  'uploads/1.jpg',
        ]);
 
    }


}
