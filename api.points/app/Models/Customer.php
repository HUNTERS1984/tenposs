<?php namespace App\Models;
  
use Illuminate\Database\Eloquent\Model;
  
class Customer extends Model{

	public function scopeMember($query, $authId, $paymentId, $serviceId ){
		return $query->where('user_id', $authId)->where('payment_id', $paymentId)->where('service_id', $serviceId);
	}
}
