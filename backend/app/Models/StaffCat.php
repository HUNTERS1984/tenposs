<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffCat extends Model
{
    //
    public $timestamps = false;
    protected $table = 'staff_categories';
    protected $fillable = ['id', 'name','store_id'];

    public function staff()
    {
        $this->hasMany(Staff::class, 'staff_category_id');
    }

    public function store()
    {
        $this->belongsTo(Store::class);
    }
}
