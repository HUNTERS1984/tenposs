<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    //
    protected $table = 'users';

    protected $fillable = ['email','password','name','full_name','sex','birthday','locale','status','company','address','tel'];

    protected $hidden =['password','remember_token'];

    public function apps(){
        return $this->hasMany(Apps::class);
    }
}
