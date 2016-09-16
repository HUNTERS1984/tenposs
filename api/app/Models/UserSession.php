<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model {
    protected $table = 'user_sessions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'token', 'type', 'app_user_id'
    ];

    public function app_user(){
    	 return $this->belongsTo(AppUser::class)->select(['id', 'email', 'social_type', 'social_id', 'app_id']);
    }
}
