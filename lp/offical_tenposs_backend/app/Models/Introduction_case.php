<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Introduction_case extends Model
{
    public $table = "introduction_cases";

    protected $fillable =['title','slug','content','img_url','status','order','intro_type_id'];

    public function intro_types(){
    	return $this->belongsTo('App\Models\Introduction_type','intro_type_id');
    }
}
