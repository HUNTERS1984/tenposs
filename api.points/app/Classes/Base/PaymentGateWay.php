<?php 
/**
* Utility class with common methods
*/
namespace App\Classes\Base;

class PaymentGateWay extends Common
{
	/**
	 * if this is sandbox
	 * @var boolean
	 */
	public $is_sandbox = true;

	/**
	 * orverried parent constructor
	 * @param array $option 
	 */				
	public function __construct($option = array()){
		parent::__construct($option);
	}

	protected function showError($e)
	{
		$body = $e->getJsonBody();
	  	$err  = $body['error'];

	  	print('Status is:' . $e->getHttpStatus() . "\n");
	  	print('Type is:' . (isset($err['type']) ? $err['type'] : '') . "\n");
	  	print('Code is:' . (isset($err['code']) ? $err['code'] : '') . "\n");
	  	// param is '' in this case
	  	print('Param is:' . (isset($err['param']) ? $err['param'] : '') . "\n");
	  	print('Message is:' . (isset($err['message']) ? $err['message'] : '') . "\n");
	  	die;
	}
}