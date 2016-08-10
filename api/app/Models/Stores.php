<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    //
    protected $table = 'stores';
    
    // 1 stores has many address
    public function address(){
        return $this->hasMany('App\Models\Addresses','store_id','id');
    }

    public function photo_categories(){
        return $this->hasMany('App\Models\PhotoCategories','store_id','id');
    }

    public function coupons(){
        return $this->hasMany('App\Models\Coupons','store_id','id');
    }
}
