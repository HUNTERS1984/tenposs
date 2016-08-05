<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    //
    protected $table = 'stores';
    public function store_top_main_image(){
        return $this->hasMany('App\Models\StoreTopMainImages','store_id','id');
    }
}
