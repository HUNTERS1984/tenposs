<?php

return array(
	# Account credentials from developer portal
	'Account' => array(
		'ClientId' => 'ARcuagIArin9BeOI0Y5R6SL-KwMSDtkAvMvGxkpK8k-Opjq2QlDytdoPON7iJmAdqZFbkj_XZXTP4bK6',
		'ClientSecret' => 'EOZAVC6mbHfB8R7H4MufjcREXWrAfEW0tK7_aPBXIk6XUq8SMxbf1L57gbr6Rm5ioPVOSHBITKohQpeN',
	),

	# Connection Information
	'Http' => array(
		// 'ConnectionTimeOut' => 30,
		'Retry' => 1,
		//'Proxy' => 'http://[username:password]@hostname[:port][/path]',
	),

	# Service Configuration
	'Service' => array(
		# For integrating with the live endpoint,
		# change the URL to https://api.paypal.com!
		'EndPoint' => 'https://api.sandbox.paypal.com',
	),


	# Logging Information
	'Log' => array(
		//'LogEnabled' => true,

		# When using a relative path, the log file is created
		# relative to the .php file that is the entry point
		# for this request. You can also provide an absolute
		# path here
		'FileName' => '../PayPal.log',

		# Logging level can be one of FINE, INFO, WARN or ERROR
		# Logging is most verbose in the 'FINE' level and
		# decreases as you proceed towards ERROR
		'LogLevel' => 'FINE',
	),
);
