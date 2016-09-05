<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'app_app_id',
        'app_app_secret',
        'description',
        'status'
    ];

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

   	public function app_setting()
    {
        return $this->hasOne(AppSetting::class)->select(['id', 'app_id', 'title', 'title_color', 'font_size', 'font_family', 'header_color', 'menu_icon_color', 'menu_background_color' ,'menu_font_color', 'menu_font_size', 'menu_font_family', 'template_id']);
    }

    public function top_components()
    {
        return $this->belongsToMany(Component::class, 'rel_app_settings_components', 'app_setting_id', 'component_id')->select(array('id', 'name'));
    }

    public function side_menu()
    {
        return $this->belongsToMany(Component::class, 'rel_app_settings_sidemenus', 'app_setting_id', 'sidemenu_id')->select(array('id', 'name'));
    }

    public function stores()
    {
        return $this->hasMany(Store::class)->select(['id', 'name', 'app_id']);
    }
    

    public function app_users(){
        return $this->hasMany(AppUser::class);
    }
    
}
