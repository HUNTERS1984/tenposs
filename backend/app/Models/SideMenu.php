<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SideMenu extends Model
{	
   protected $table = 'sidemenus';
   protected $fillable = ['id', 'name']; 
}