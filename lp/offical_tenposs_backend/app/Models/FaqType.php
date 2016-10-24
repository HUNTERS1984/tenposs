<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqType extends Model
{
    public $table = 'faqtypes';

    protected $fillable = ['title'];

    public function faqs()
    {
    	return $this->hasMany('App\Models\Faq','faqtype_id');
    }
}
