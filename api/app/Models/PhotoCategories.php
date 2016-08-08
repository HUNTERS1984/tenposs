<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCategories extends Model
{
    //
    protected $table = 'photo_categories';

    public $timestamps = false;

    public function photo(){
        return $this->hasMany('App\Models\Photos','photo_category_id','id');
    }
}
