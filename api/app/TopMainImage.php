<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopMainImage extends Model
{
    //
    protected $table = 'app_top_main_images';

    protected $fillable = ['image_url','app_id'];
}
