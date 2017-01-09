<?php
/**
* Stripe Gateway payment
*/
namespace App\Classes\Payment;
use App\Classes\Base\PaymentGateWay;
use GuzzleHttp\Client;
use App\Models\Customer;
use App\Models\Purchase;
/**
* Paid.jp payment
*/
class Paid_Payment extends PaymentGateWay
{
	const MEMBER_REGISTER_ENDPOINT = 'https://paid.jp/y/coop/member/register/ver1.0/p.json';
	
	const MEMBER_CHECK_ENDPOINT = 'https://paid.jp/y/coop/member/check/ver1.0/p.json';

	const CREDIT_CHECK_ENDPOINT = 'https://paid.jp/y/coop/member/creditCheck/ver1.0/p.json';

	const CREDIT_REGISTER_ENDPOINT = 'https://paid.jp/y/coop/Register/b2bMemberId/ver1.0/p.json';

	const CREDIT_FIX_ENDPOINT = 'https://paid.jp/y/coop/Fix/b2bCreditId/ver1.0/p.json';

	private $client;
	private $apiAuthCode = 'e5dd52df35aa9879ed7cacd541aad0d4';

	private $_defaultError = [
		'success' => false,
		'detail' => [
			'message' => '決済サーバとの間で接続エラーが発生しました。',
		]				
	];

	private $_purchase;

	public function __construct(){
		$this->client = new Client();
		$this->_purchase = new Purchase();
	}

	public function memberRegister(array $memberData = array())
	{
		$apiUrl = self::MEMBER_REGISTER_ENDPOINT;
		
		$body['memberData'] = $memberData;
		$response = $this->apiConnect($apiUrl, $body);
		if(!$response) {
			return $this->_defaultError;
		}
		else{
			$headerStatus = $response->header->status;
			$bodyResult = $response->body->result;
			if($headerStatus == 'SUCCESS'){
				return [
					'success' => true,
					'detail' => array(),
					'data' => $bodyResult
				];
			}
			else{	
				
				$data = $this->handlerError($bodyResult->error);
				return [
					'success' => false,
					'detail' => array(
						'data' => $data
					),					
				];
			}
		}
	}

	public function memberCheck($b2bMemberId)
	{
		$apiUrl = self::MEMBER_CHECK_ENDPOINT;
		$body['b2bMemberIds'] = [];
		array_push($body['b2bMemberIds'], $b2bMemberId);		 
		$response = $this->apiConnect($apiUrl, $body);
		if(!$response) {
			return $this->_defaultError;
		}
		else{
			$headerStatus = $response->header->status;
			$bodyResults = $response->body->results;
			if($headerStatus == 'SUCCESS' && isset($bodyResults->successes)){
				$successes = $bodyResults->successes[0];
				$memberStatusCode = $successes->memberStatusCode;
				return [
					'success' => true,
					'detail' => array(),
					'data' => [
						'message' => $this->memberStatusCode($memberStatusCode),
						'b2bMemberId' => $b2bMemberId
					]
				];
			}
			else{	
				$error = $bodyResults->errors[0]->error;
				$data = $this->handlerError($error);
				return [
					'success' => false,
					'detail' => array(
						'data' => $data
					),					
				];
			}
		}
	}

	public function creditCheck(array $params = array())
	{
		$apiUrl = self::CREDIT_CHECK_ENDPOINT;
		$body['credit'] = $params;
		$response = $this->apiConnect($apiUrl, $body);
		if(!$response) {
			return $this->_defaultError;
		}
		else{
			$headerStatus = $response->header->status;
			$bodyResult = $response->body->result;
			
			if($headerStatus == 'SUCCESS'){
				$creditAvailable = $bodyResult->creditAvailable;
				$memberStatusCode = $bodyResult->memberStatusCode;
				if($creditAvailable) {
					return [
						'success' => true
					];
				}
				else{
					return [
						'success' => false,
						'detail' => [
							$this->memberStatusCode($memberStatusCode)
						]
					];
				}
				
			}
			else{	
				
				$messages = $bodyResult->message;
				return [
					'success' => false,
					'detail' => $messages		
				];
			}
		}
	}

	public function creditRegister(array $params = array())
	{
		$apiUrl = self::CREDIT_REGISTER_ENDPOINT;

		$body['credits']['credit'] = array($params);
		
		$response = $this->apiConnect($apiUrl, $body);
		
		if(!$response) {
			return $this->_defaultError;
		}
		else{
			$headerStatus = $response->header->status;					
			if($headerStatus == 'SUCCESS'){
				$bodyResult = $response->body->detailResults;
				if(isset($bodyResult->detailResult[0]->status)){
					$status = $bodyResult->detailResult[0]->status;
					if($status == 'SUCCESS'){
						return [
							'success' => true
						];
					}
				}
				return [
					'success' => false
				];
				
				
							
			}
			else{	
				$bodyResult = $response->body->detailResults;
				return [
					'success' => false,
					'detail' => $bodyResult->detailResult
				];
			}
		}
	}


	public function creditFix(array $params = array())
	{
		$apiUrl = self::CREDIT_FIX_ENDPOINT;
		$body['credits']['credit'] = [];
		array_push($body['credits']['credit'], $params);
		$response = $this->apiConnect($apiUrl, $body);

	
		if(!$response) {
			return $this->_defaultError;
		}
		else{
			$headerStatus = $response->header->status;		
				
			if($headerStatus == 'SUCCESS'){
				$bodyResult = $response->body->detailResults;
				if(isset($bodyResult->detailResult[0]->status)){
					$status = $bodyResult->detailResult[0]->status;
					if($status == 'SUCCESS'){
						return [
							'success' => true
						];
					}
				}
				return [
					'success' => false
				];				
			}
			else{				
				$bodyResult = $response->body->detailResults;
				return [
					'success' => false,
					'detail' => $bodyResult->detailResult
				];
			}
		}
	}

	public function createBillingPlan($type){		
		$data = (object) [
			'id' => 'basic-monthly_'.microtime(true)
		];
		
        return $data;
	}

	public function setCreditCheckParams($customer, $price)
	{
		$b2bMemberId = $customer->customer_id;
		return [
            'b2bMemberId' => $b2bMemberId,
            'price' => $price
        ];
	}

	public function setCreditRegisterParams($b2bMemberId, $code, $b2bCreditId, $amount)
	{
		return [
            'b2bMemberId' => $b2bMemberId,
            'contents' => 'demo payment for tenposs',
            'code' => $code,
            'price' => $amount,
            'b2bCreditId' => $b2bCreditId,
        ];
	}

	public function creditNewPurchase($userId, $paymentId, $billingPlan)
	{
		try {
			$serviceId = $billingPlan->service_id;
			$amount = $billingPlan->amount;
			$cu = Customer::member($userId, $paymentId, $serviceId)->first();

			if(!$cu) return false;
			
			$params = $this->setCreditCheckParams($cu, $amount);

			$creditCheck = $this->creditCheck($params);
			if(!$creditCheck['success']) return false;

			$codeId = $this->generate_code_id(15);
			$payment_code = $this->generate_code_id();
			
	        $purchase = $this->_purchase->newPurchase($codeId, $payment_code, $paymentId, $serviceId, $userId);
	        $b2bMemberId = $cu->customer_id;
	        $code = $purchase->code;
	        $b2bCreditId = $purchase->payment_code;

	        $cdRegisParams = $this->setCreditRegisterParams($b2bMemberId, $code, $b2bCreditId, $amount);

	        $creditRegister = $this->creditRegister($cdRegisParams);
	        if(!$creditCheck['success']) return false;
	        
	        $params = [
                'b2bMemberId' => $b2bMemberId,
                'fixedAt' => date('Y/m/d'),
                'b2bCreditId' => $b2bCreditId,
            ];

            $creditFix = $this->creditFix($params);
            if(!$creditCheck['success']) return false;
            $purchase->status = 1;
            return true;
			
		} 
		catch (\GuzzleHttp\Exception\ConnectException $e) {
		    $this->showError($e);
		}
		catch (Exception $e) {
			$this->showError($e);
		}
		return false;
	}

	public function createBillingAgreement($userId, $paymentId, $billingPlan)
	{
		
		$purchase = $this->creditNewPurchase($userId, $paymentId, $billingPlan);
		if($purchase){
			return (object) [
				'subscriptionId' => null
			];
		}
		else{
			return false;
		}
		
	}

	public function suspendBillingAgreement()
	{
		return true;
	}

	/*PRIVATE FUNCTION*/
	private function memberStatusCode($code)
	{
		switch ($code) {
			case 1:
				$message = '審査中';
				break;
			case 1:
				$message = '利用可能-取引中';
				break;
			case 1:
				$message = '利用可能-取引不可';
				break;
			case 1:
				$message = '利用不可';
				break;
			default:
				$message = '審査中';
				break;
		}
		return $message;
	}

	private function handlerError($error)
	{
		$data = array_map(function ($code)
		{
			return array_merge(Paid_Error_Handler::get_error_message($code), ['code' => $code]);
		},$error);
		return $data;
	}

	private function apiConnect($url, $body)
	{
		$response = $this->client->request('POST', $url, [
		    'json' => [
		        'body' => $body,
		        'header' => ['apiAuthCode' => $this->apiAuthCode]
		    ],
		    'headers' => [
		    	'Content-Type' => 'application/json; charset=UTF-8'
		    ]
		]);

		return $this->apiResponse($response);
	}

	private function apiResponse($response)
	{
		$statusCode = $response->getStatusCode();	
		if($statusCode == 200){
			$responseBody = $response->getBody();
	        $remainingBytes = $responseBody->getContents();
	        $return = [];
	        try {
	        	$remainingBytes = json_decode($remainingBytes);		        	
	        	return $remainingBytes;
	        } catch (Exception $e) {
	        	return false;
	        }
		}
		else{
			return false;
		}
	}

	/**
     * Generate uniq transaction ID
     * @return string
     */
    public function generate_code_id($length = 20){
        return substr(uniqid(sprintf('%s-%02d-', 'pjp', rand(0,99)), true).time(), 0, $length);
    }
}