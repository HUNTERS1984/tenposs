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

    public function tags(){
        return $this->belongsToMany(Tag::class, 'rel_coupons_tags', 'coupon_id', 'tag_id');
    }

    public function app_users(){
        return $this->belongsToMany(AppUser::class, 'rel_app_users_coupons', 'coupon_id', 'app_user_id');
    }
}
