<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUsers extends Model
{
    //
    protected $table = 'app_users';
    public function user_profiles(){
        return $this->hasMany('App\Models\UserProfiles','app_user_id','id');
    }
}
