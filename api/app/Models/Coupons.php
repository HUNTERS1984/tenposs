<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    //
    protected $table = 'coupons';

    public function items(){
        return $this->hasMany('App\Models\Items','coupon_id','id');
    }
}
