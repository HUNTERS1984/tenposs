<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table ="menus";

    protected $fillable =['name','store_id'];

    public $timestamps = false;
}
