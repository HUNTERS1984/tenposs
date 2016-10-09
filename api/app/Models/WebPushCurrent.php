<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebPushCurrent extends Model
{
    protected $table = 'web_push_current';
    protected $primaryKey = 'id';
    protected $fillable = [
        'key', 'data_id', 'data_value', 'app_user_id'
    ];
}
