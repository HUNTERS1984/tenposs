<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Introduction_type extends Model
{
    public $table = 'introduction_types';

    protected $fillable = ['title','content','status','order'];

    public function intro_cases(){
    	return $this->hasMany('App\Models\Introduction_case','intro_type_id');
    }
}
