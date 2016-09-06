<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model {

    protected $table = 'app_users';
    protected $fillable = [
        'email', 'password', 'role', 'status', 'temporary_hash'
    ];

    public function profile(){
    	 return $this->hasOne(UserProfile::class)->select(['id', 'name', 'gender', 'address', 'avatar_url', 'facebook_status', 'twitter_status', 'instagram_status', 'app_user_id']);
    }

    public function social(){
         return $this->hasOne(SocialProfile::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'rel_app_users_coupons', 'app_user_id', 'coupon_id');
    }
}
