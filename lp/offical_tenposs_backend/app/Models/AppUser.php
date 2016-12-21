<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use cURL;
use Config;
use Session;

class AppUser extends Model {

    protected $table = 'app_users';
    protected $fillable = [
        'email', 'password', 'role', 'status', 'temporary_hash', 'point'
    ];

    protected $appends = ['point'];

    public function profile(){
    	 return $this->hasOne(UserProfile::class)
             ->select(['id',
                 'name',
                 'gender',
                 'age',
                 'stage',
                 'position',
                 'address',
                 'avatar_url',
                 'facebook_status',
                 'twitter_status',
                 'instagram_status',
                 'app_user_id'])->whereNull('deleted_at');
    }

    public function getPointAttribute()
    {
        $app_data = App::where('user_id', Session::get('user')->id )->first();
        if ($app_data) {
             $response = cURL::newRequest('get', Config::get('api.api_point_user')."?app_id=".$app_data->app_app_id.'&user_id='.$this->id)
            ->setHeader('Authorization',  'Bearer '. Session::get('jwt_token')->token)->send();
            $point_info = json_decode($response->body);
            //dd($point_info);
            if ($point_info)
                return $point_info->data;
        }
        
        return '';
    }

    public function social(){
         return $this->hasOne(SocialProfile::class, 'app_user_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'rel_app_users_coupons', 'app_user_id', 'coupon_id');
    }



    public function sessions(){
        return $this->hasMany(UserSession::class);
    }
}
