<?php

namespace App\Models;
use Carbon\Carbon;
use Hash;
use DB;
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
        
        // Create app default info
        $app = new \App\Models\App;
        $app->name = $this->app_name_register;
        $app->app_app_id = md5(uniqid(rand(), true));
        $app->app_app_secret = md5(uniqid(rand(), true));
        $app->description =  'なし';
        $app->status = 1;
        $app->business_type = $this->business_type;
        $app->user_id = $this->id;
        $app->save();
        // Set default app templates 1   
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
        $appSetting->save();
        
        // Set rel_app_settings_sidemenus, rel_app_settings_components 
        
        $component = DB::table('components')
                    ->whereNotNull('sidemenu')
                    ->get();
        
        $i = 0;$j = 0;
        foreach( $component as $com){
            if( $com->top !== '' ){
                DB::table('rel_app_settings_components')->insert(
                    [
                        'app_setting_id' => $appSetting->id,
                        'component_id' => $com->id
                    ]
                );
                $j++;
            }
            
            
            if( $com->sidemenu !== '' ){
                DB::table('rel_app_settings_sidemenus')->insert([
                    'app_setting_id' => $appSetting->id,
                    'sidemenu_id' => $com->id,
                    'order' => $i
                ]);
                $i++;
            }

            
        }
        // Create app_stores,rel_apps_stores default
        
        $stores_default = DB::tables('app_stores')->all();
        
        foreach($stores_default as $store){
           
            DB::table('rel_apps_stores')->insert([
                'app_id' => $app->id,
                'app_store_id' => $store->id,
                'version' => '1.0'
            ]);
            
        }
        
        // setting default rel_app_stores
        DB::table('app_top_main_images')->insert([
            'app_setting_id' => $appSetting->id,
            'image_url' =>  'uploads/1.jpg',
        ]);
 
    }


}
