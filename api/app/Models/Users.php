<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    protected $table = 'users';
    // Users has many apps
    public function apps(){
        return $this->hasMany('App\Models\Apps','user_id','id');
    }
}
