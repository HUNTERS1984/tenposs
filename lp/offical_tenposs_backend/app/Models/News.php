<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $table = "news";

    protected $fillable =['title','slug','content','img_url','status','order'];
}
