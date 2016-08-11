<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppTopMainImages extends Model
{
    //
    protected $table = 'app_top_main_images';
    public function app(){
        return $this->belongsTo('App\Models\Apps','app_id');
    }
}
