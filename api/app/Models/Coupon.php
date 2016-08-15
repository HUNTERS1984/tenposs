<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $table = 'coupons';

    public function items(){
        return $this->hasMany(Item::class);
    }
}
