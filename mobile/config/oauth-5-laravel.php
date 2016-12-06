<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => '159391921181596',
			'client_secret' => 'cc9ad24a6a123349ada67fb373067fbc',
			'scope'         => ['email'],
		],
		
		'Twitter' => [
			'client_id'     => 'RwA2MxYOwBwVC8AvjbWzL34Sw',
			'client_secret' => 'Ise1bqJluX3ZN2SwOZw3rSPBRYOJwsQt72Pxct7S2HYRrglDKc',
		],

		'Instagram' => [
			'client_id'     => '17d7e27257b74d05b352fc55692b2b59',
			'client_secret' => '459fecbe46f04639852268e390189d1a',
		],


		
	]

];