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
			'client_id'     => '570059106506930',
			'client_secret' => '7493266245fb5e678e67f7de0c018d91',
			'scope'         => ['email'],
		],
		
		'Twitter' => [
			'client_id'     => 'qY0dnYDqh99zztg8gBWkLIFrm',
			'client_secret' => 'Byy6PCW51zvhVrDZayLm8PhenqkHXiRIqLMpK7A5H5XNEzlKYi',
		],

		'Instagram' => [
			'client_id'     => 'cd9f614f85f44238ace18045a51c44d1',
			'client_secret' => 'd839149848c04447bd379ce8bff4d890',
		],


		
	]

];