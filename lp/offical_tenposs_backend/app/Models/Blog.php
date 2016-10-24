<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $table = 'blogs';

    protected $fillable =['title','slug','content','img_url','status','order'];
}
