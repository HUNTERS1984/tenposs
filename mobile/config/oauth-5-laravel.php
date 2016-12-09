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
			'client_id'     => 'qY0dnYDqh99zztg8gBWkLIFrm',
			'client_secret' => 'Byy6PCW51zvhVrDZayLm8PhenqkHXiRIqLMpK7A5H5XNEzlKYi',
		],

		'Instagram' => [
			'client_id'     => '17d7e27257b74d05b352fc55692b2b59',
			'client_secret' => '459fecbe46f04639852268e390189d1a',
		],


		
	]

];