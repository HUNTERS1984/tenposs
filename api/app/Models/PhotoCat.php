<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCat extends Model {
//    public $timestamps = false;
    protected $table = 'photo_categories';
    protected $fillable = ['id', 'name'];
}
