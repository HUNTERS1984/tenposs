<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model {

    protected $table = 'staffs';
    protected $fillable = ['price','image_url','introduction', 'name', 'gender', 'birthday', 'tel'];

    public function staff_categories()
    {
        return $this->belongsTo(StaffCategory::class);
    }


}
