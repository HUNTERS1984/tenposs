<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model
{
    //
    protected $table='photo_categories';

    public function photo()
    {
        return $this->hasMany(Photo::class);
    }
}
