<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'messages';
    public $timestamps = false;
    protected $fillable = ['channel_id','from_mid','to_mid','message'];
}
