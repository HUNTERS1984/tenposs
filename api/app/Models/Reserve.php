<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{	
   protected $table = 'reserves';
   protected $fillable = ['id', 'reserve_url']; 
   public function products()
   {
   		return $this->belongsToMany(Product::class, 'rel_categories_products');
   }
}
