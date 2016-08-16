<?php

return [

    'sig_top' => array('app_id', 'time'),
    'sig_appinfo' => array('app_id', 'time'),
    'sig_signup' => array('app_id', 'time', 'email', 'password'),
    'sig_social_login' => array('app_id', 'time', 'social_type', 'social_id'),
    'sig_signin' => array('app_id','time', 'email'),
    'sig_signout' => array('token','time'),
    'sig_menu' => array('app_id','time','store_'),
    'sig_items' => array('app_id','time','menu_id'),
    'sig_news' => array('app_id','time','store_id'),
    'sig_photo_cat' => array('app_id','time','store_id'),
    'sig_photo' => array('app_id','time','category_id'),
    'sig_reserve' => array('app_id','time','store_id'),
];