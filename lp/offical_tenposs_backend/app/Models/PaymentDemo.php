<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDemo extends Model {

    protected $table = 'paymentdemo';
    public $timestamps = false;
    protected $fillable = ['id', 'code'];
}