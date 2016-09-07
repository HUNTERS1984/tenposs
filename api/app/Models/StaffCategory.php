<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffCategory extends Model
{
	// protected $dates = ['deleted_at'];
    protected $table = 'staff_categories';
    protected $fillable = ['id', 'name'];
    public $timestamps = false;


    public function staffs(){
        return $this->hasMany(Staff::class,'staff_category_id');
    }

    public function store(){
    	 return $this->belongsTo(Store::class);
    }
}