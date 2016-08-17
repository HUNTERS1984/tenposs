<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model {

    protected $table = 'app_settings';

    public function images() {
        return $this->hasMany(AppTopMainImage::class)->select('image_url');
    }

}
