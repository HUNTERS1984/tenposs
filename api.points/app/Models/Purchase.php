<?php namespace App\Models;
  
use Illuminate\Database\Eloquent\Model;
  
class Purchase extends Model{

    const SUCCESS = 1;
    const FAILED = 0;
	public function newPurchase( $code, $payment_code, $paymentId, $serviceId, $userId)
	{
        $this->code = $code;
        $this->payment_code = $payment_code;
        $this->payment_id = $paymentId;
        $this->service_id = $serviceId;
        $this->user_id = $userId;
        $this->save();
        return $this;
	}

    public function scopeSuccess($query, $userId, $paymentId, $serviceId)
    {
        return $query->where('user_id',$userId)->where('payment_id', $paymentId)->where('service_id', $serviceId)->where('status', self::SUCCESS);
    }
}
