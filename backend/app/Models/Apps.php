<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
    //
    protected $table = 'apps';
    public function user(){
        return $this->belongsTo(Users::class);
    }
}
