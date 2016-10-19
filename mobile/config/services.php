<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    
    'facebook' => [
        'client_id' => '159391921181596',
        'client_secret' => 'cc9ad24a6a123349ada67fb373067fbc',
        'redirect' => 'https://'.$_SERVER['SERVER_NAME'].'/login/callback/facebook',
    ],
    
    'twitter' => [
        'client_id' => 'qY0dnYDqh99zztg8gBWkLIFrm',
        'client_secret' => 'Byy6PCW51zvhVrDZayLm8PhenqkHXiRIqLMpK7A5H5XNEzlKYi',
        'redirect' => 'https://'.$_SERVER['SERVER_NAME'].'/login/callback/twitter',
    ],
    
    'instagram' => [
        'client_id' => '17d7e27257b74d05b352fc55692b2b59',
        'client_secret' => '459fecbe46f04639852268e390189d1a ',
        'redirect' => 'https://'.$_SERVER['SERVER_NAME'].'/login/callback/instagram',
    ],
    
    

];
