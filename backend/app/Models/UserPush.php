<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPush extends Model {
    protected $table = 'user_pushs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ranking', 'news', 'coupon', 'chat'
    ];

    public function app_user(){
    	 return $this->belongsTo(AppUser::class);
    }
}
