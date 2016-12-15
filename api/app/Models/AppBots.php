<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppBots extends Model
{

    protected $table = 'app_bots';


   	public function app()
    {
        return $this->belongsTo(App::class,'app_id');
    }

}
