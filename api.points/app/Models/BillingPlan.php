<?php namespace App\Models;
  
use Illuminate\Database\Eloquent\Model;
  
class BillingPlan extends Model
{
     
     protected $fillable = ['paypal_billing_plan_id', 'service_id'];
     
}
?>