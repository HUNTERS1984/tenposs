<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //
    public $table = 'staffs';
    protected $fillable = ['name','price','image_url', 'introduction','gender','birthday','tel','staff_category_id'];
}
