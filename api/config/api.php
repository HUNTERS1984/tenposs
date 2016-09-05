<?php

return [
    'time_expire' => 5000000,

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
    'sig_coupon' => array('app_id','time','store_id'),
    'sig_profile' => array('token','time'),

    'cache_news' => 'news_%s_%s_%s_%s', //app_id,store_id,pageindex,pagesize
    'cache_items' => 'items_%s_%s_%s_%s', // app_id,menu_id,pageindex,pagesize
    'cache_menus' => 'menus_%s_%s', // app_id,menu_id
    'cache_photo_cat' => 'photo_cat_%s_%s', // app_id,store_id
    'cache_photos' => 'photos_%s_%s_%s_%s', // app_id,menu_id,pageindex,pagesize
    'cache_reserve' => 'reserve_%s_%s', // app_id,store_id
    'cache_app_detail' => 'app_detail_%s', // app_id
    'cache_app_detail_token' => 'app_detail_token_%s', // token
    'cache_app_info' => 'app_info_%s', // app_id
    'cache_photos' => 'coupon_%s_%s_%s_%s', // app_id,store_id,pageindex,pagesize
    'cache_top_images' => 'top_images_%s', // app_id
    'cache_top_news' => 'top_news_%s', // app_id
    'cache_top_photos' => 'top_photos_%s', // app_id
    'cache_top_items' => 'top_items_%s', // app_id
    'cache_top_contacts' => 'top_contacts_%s', // app_id
    'cache_profile' => 'profile_%s', // app_id
];