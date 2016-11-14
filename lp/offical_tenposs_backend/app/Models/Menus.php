<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table ="menus";

    protected $fillable =['name','store_id'];

    public $timestamps = false;

    public function items(){
    	return $this->belongsToMany(Item::class,'rel_menus_items','item_id','menu_id');
    }

    public function store(){
    	 return $this->belongsTo(Store::class);
    }
}
