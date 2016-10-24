<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    //
    protected $table = 'coupon_types';

    protected $fillable =['name','store_id'];
    public $timestamps = false;
    
    public function coupons(){
        return $this->hasMany(Coupon::class);
    }
}
