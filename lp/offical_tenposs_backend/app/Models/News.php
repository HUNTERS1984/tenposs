<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $table = "news";

    protected $fillable =['title','slug','content','img_url','status','order'];
    
    public function category(){
        return $this->belongsTo(NewsCat::class,'new_category_id');
    }
}
