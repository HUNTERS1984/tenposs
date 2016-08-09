<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    //
    protected $table = 'apps';

    // apps has many app setting
    public function templates(){
        return $this->belongsToMany('App\Models\Templates','app_settings','app_id','template_id')
            ->withPivot(
                'title',
                'title_color',
                'font_size',
                'font_family',
                'header_color',
                'menu_icon_color',
                'menu_background_color',
                'menu_font_color',
                'menu_font_size',
                'menu_font_family',
                'top_main_image_url'
            )->withTimestamps();;
    }

    // apps has many stores

    public function stores(){
        return $this->hasMany('App\Models\Stores','app_id','id');
    }

    public function app_top_main_images(){
        return $this->hasMany('App\Models\AppTopMainImages','app_id','id');
    }

}
