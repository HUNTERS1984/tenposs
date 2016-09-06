<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model {

    protected $table = 'app_settings';

    public function images() {
        return $this->hasMany(AppTopMainImage::class)->select('image_url');
    }

    public function components(){
        return $this->belongsToMany(Component::class, 'rel_app_settings_components', 'app_setting_id', 'component_id')->orderBy('order', 'asc');
    }

}
