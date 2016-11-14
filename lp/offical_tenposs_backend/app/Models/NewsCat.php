<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCat extends Model
{
    public $timestamps = false;
    protected $table = 'new_categories';
    protected $fillable = ['id', 'name','store_id'];

    public function news()
    {
        $this->hasMany(News::class,'new_category_id');
    }

    public function store(){
         return $this->belongsTo(Store::class);
    }
}
