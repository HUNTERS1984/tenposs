<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

    protected $table = 'addresses';
    protected $fillable = ['id', 'last_name', 'first_name', 'zip_code', 'province', 'district', 'street', 'building_name', 'phone_number', 'free_mail','user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}