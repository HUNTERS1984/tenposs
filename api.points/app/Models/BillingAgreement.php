<?php namespace App\Models;
  
use Illuminate\Database\Eloquent\Model;
  
class BillingAgreement extends Model{
    protected $fillable = ['paypal_billing_agreement_id', 'billing_plan_id'];

    public function billingPlan()
    {
        return $this->belongsTo('App\Models\BillingPlan');
    }
}
?>