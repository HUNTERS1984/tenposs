<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{	
    protected $table = 'stores';
    protected $fillable = ['id', 'name','app_id']; 
    public function app(){
    	 return $this->belongsTo(App::class);
    }

    public function menus(){
    	 return $this->hasMany(Menu::class);
    }

    public function photo_cats(){
    	 return $this->hasMany(PhotoCat::class);
    }
   
   	public function news(){
    	 return $this->hasMany(News::class);
    }

    public function addresses(){
    	 return $this->hasOne(Address::class);
    }

}