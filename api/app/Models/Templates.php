<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    //
    protected $table = 'templates';
    // Templates get many apps
    public function apps(){
        return $this->belongsToMany('App\Models\Apps','app_settings','template_id','app_id')
            ->withTimestamps();
    }
}
