<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $dates = ['deleted_at'];
    protected $table = 'news';
    protected $fillable = ['title', 'date', 'description', 'image_url','store_id'];
    public $timestamps = false;

   
}