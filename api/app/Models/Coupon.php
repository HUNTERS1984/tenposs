<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $table = 'coupons';
    protected $fillable =['title','description', 'start_date', 'end_date', 'status', 'image_url', 'coupon_type_id'];

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function coupon_type(){
        return $this->belongsTo(CouponType::class);
    }
}
