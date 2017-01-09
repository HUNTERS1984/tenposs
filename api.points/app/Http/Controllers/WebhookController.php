<?php

/**
* Webhook controller receive information from payment gateway
*/
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use Log;

class WebhookController extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function all(Request $request)
	{
		Log::debug('Webhook Request');
		$input = $request->all();
		Log::debug('Webhook', $input);
	}
}
