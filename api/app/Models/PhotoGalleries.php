<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoGalleries extends Model
{
    protected $table = "photo_categories";

    protected $fillable =['name','app_id'];
}
