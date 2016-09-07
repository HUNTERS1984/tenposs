<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPushLogTracking extends Model
{
    //
    protected $table = 'user_push_log_tracking';
    protected $fillable = [
        'type', 'data_id', 'data_value', 'platform', 'created_by', 'updated_by', 'notify_status', 'app_user_id'
    ];
}
