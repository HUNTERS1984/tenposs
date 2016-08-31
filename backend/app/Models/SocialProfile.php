<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialProfile extends Model {

    protected $table = 'social_profiles';
    protected $fillable = ['social_type', 'social_token', 'social_secret', 'nickname', 'social_id', 'json'];
}
