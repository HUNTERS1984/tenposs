<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model {

    protected $table = 'user_profiles';
    protected $fillable = ['name', 'gender', 'address', 'avartar_url', 'facebook_status', 'twitter_status', 'instagram_status', 'facebook_token', 'twitter_token', 'instagram_token'];
//    public $timestamps = false;

}
