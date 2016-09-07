<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoCat extends Model {
    public $timestamps = false;
    protected $table = 'photo_categories';
    protected $fillable = ['id', 'name'];

<<<<<<< HEAD
    public $timestamps = false;

     public function photo(){
    	 return $this->hasMany(Photo::class,'photo_category_id');
=======
    public function photo(){
        return $this->hasMany(Photo::class,'photo_category_id');
    }

    public function store(){
    	 return $this->belongsTo(Store::class);
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
    }
}

