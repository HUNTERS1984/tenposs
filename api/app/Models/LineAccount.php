<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineAccount extends Model
{
    //
    //
    protected $table = 'line_accounts';
    
    protected $fillable = [
        'mid',
        'app_user_id',
        'displayName',
        'pictureUrl',
        'statusMessage',
        'access_token',
        'token_type',
        'expires_in',
        'refresh_token',
        'scope'
    ];
}
