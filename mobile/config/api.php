<?php

return [
    'url' => 'https://api.ten-po.com/api/v1/',
    'secret_key' => 'Tenposs@123',
    'time_expire' => 5000000,
    //sig
    'sig_top' => array('app_id', 'time'),
    'sig_appinfo' => array('app_id', 'time'),
    'sig_signup' => array('app_id', 'time', 'email', 'password'),
    'sig_social_login' => array('app_id', 'time', 'social_type', 'social_id'),
    'sig_signin' => array('app_id', 'time', 'email'),
    'sig_signout' => array('token', 'time'),
    'sig_menu' => array('app_id', 'time', 'store_id'),
    'sig_items' => array('app_id', 'time', 'menu_id'),
    'sig_items_relate' => array('app_id','time','item_id'),
    'sig_items_detail' => array('app_id','time','item_id'),
    'sig_news' => array('app_id', 'time'),
    'sig_news_cat' => array('app_id', 'time', 'store_id'),
    'sig_photo_cat' => array('app_id', 'time', 'store_id'),
    'sig_photo' => array('app_id', 'time', 'category_id'),
    'sig_reserve' => array('app_id', 'time', 'store_id'),
    'sig_coupon' => array('app_id', 'time', 'store_id'),
    'sig_profile' => array('token', 'time'),
    'sig_social_profile' => array('token', 'social_type', 'social_id', 'social_token', 'social_secret', 'nickname', 'time'),
    'sig_staff_category' => array('app_id', 'time', 'store_id'),
    'sig_staffs' => array('app_id', 'time', 'category_id'),
    'sig_news_detail' => array('app_id', 'time', 'id'),
    'sig_coupon_detail' => array('app_id', 'time', 'id'),
    'sig_app_domain' => array('domain','time'),

    'secret_key_for_domain' => 'Tenposs@123',
];