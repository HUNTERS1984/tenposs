<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $timestamps = false;
	protected $dates = ['deleted_at'];
    protected $table = 'news';
    protected $fillable = ['title', 'date', 'description', 'image_url'];

    public function news_cat(){
    	 return $this->belongsTo(NewCat::class, 'new_category_id');
    }
}