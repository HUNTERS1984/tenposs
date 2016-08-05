<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTopMainImages extends Model
{
    //
    protected $table = 'store_top_main_images';
    public function store(){
        return $this->belongsTo('App\Models\Stores','store_id');
    }
}
