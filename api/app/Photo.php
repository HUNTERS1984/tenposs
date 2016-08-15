<?php

namespace App;

use App\Models\PhotoCategories;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    protected $table='photos';

    public function photocategory()
    {
        return $this->belongsTo(PhotoCategories::class);
    }
}
