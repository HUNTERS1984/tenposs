<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apps extends Model
{
    //
    use SoftDeletes;
    protected $table = 'apps';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'status'
    ];

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
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
            )->withTimestamps();
    }

    // apps has many stores

    public function stores(){
        return $this->hasMany('App\Models\Stores','app_id','id');
    }

    public function app_top_main_images(){
        return $this->hasMany('App\Models\AppTopMainImages','app_id','id');
    }

    public function app_users(){
        return $this->hasMany('App\Models\AppUsers','app_id','id');
    }



}
