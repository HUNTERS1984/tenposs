<?php

return [
    'media_base_url' => 'https://ten-po.com/',
    'media_base_url_api' => 'https://api.ten-po.com/',

    'time_expire' => 5000000,

    //items
    'items_notification' => array('app_user_id', 'type', 'created_by'),
    //sig
    'sig_top' => array('app_id', 'time'),
    'sig_appinfo' => array('app_id', 'time'),
    'sig_app_secret_info' => array('app_id', 'time'),
    'sig_signup' => array('app_id', 'time', 'email', 'password'),
    'sig_social_login' => array('app_id', 'time', 'social_type', 'social_id'),
    'sig_signin' => array('app_id', 'time', 'email'),
    'sig_signout' => array('token', 'time'),
    'sig_menu' => array('app_id', 'time', 'store_id'),
    'sig_items' => array('app_id', 'time', 'menu_id'),
    'sig_items_relate' => array('app_id', 'time', 'item_id'),
    'sig_items_detail' => array('app_id', 'time', 'item_id'),
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
    'sig_staff_detail' => array('app_id', 'time', 'id'),
    'sig_news_detail' => array('app_id', 'time', 'id'),
    'sig_coupon_detail' => array('app_id', 'time', 'id'),
    'sig_app_domain' => array('domain', 'time'),
    'sig_get_push_setting' => array('token', 'time'),
    'sig_set_push_setting' => array('token', 'ranking', 'news', 'coupon', 'chat', 'time'),
    'sig_web_push_current' => array('app_id', 'key', 'time'),
    'sig_delete_data_web_notification' => array('app_id', 'id', 'time'),
    'sig_set_push_key' => array('token', 'client', 'key', 'time'),
    'sig_coupon_use' => array('token', 'time', 'app_user_id', 'coupon_id', 'staff_id'),
    'sig_share_get_code' => array('app_id', 'time'),
    'sig_social_profile_cancel' => array('token', 'social_type', 'time'),
    'sig_create_virtual_host' => array('domain', 'domain_type', 'time'),

    'cache_news' => 'news_%s_%s_%s_%s', //app_id,category_id,pageindex,pagesize
    'cache_news_cat' => 'news_cat_%s_%s', // app_id,store_id
    'cache_items' => 'items_%s_%s_%s_%s', // app_id,menu_id,pageindex,pagesize
    'cache_items_relate' => 'items_%s_%s_%s_%s', // app_id,item_id,pageindex,pagesize
    'cache_items_detail' => 'items_%s_%s', // app_id,item_id
    'cache_menus' => 'menus_%s_%s', // app_id,menu_id
    'cache_photo_cat' => 'photo_cat_%s_%s', // app_id,store_id
    'cache_photos' => 'photos_%s_%s_%s_%s', // app_id,category_id,pageindex,pagesize
    'cache_reserve' => 'reserve_%s_%s', // app_id,store_id
    'cache_app_detail' => 'app_detail_%s', // app_id
    'cache_app_detail_token' => 'app_detail_token_%s', // token
    'cache_app_info' => 'app_info_%s', // app_id
    'cache_coupons' => 'coupon_%s_%s_%s_%s_%s', // app_id,store_id, token,pageindex,pagesize
    'cache_top_images' => 'top_images_%s', // app_id
    'cache_top_news' => 'top_news_%s', // app_id
    'cache_top_photos' => 'top_photos_%s', // app_id
    'cache_top_items' => 'top_items_%s', // app_id
    'cache_top_contacts' => 'top_contacts_%s', // app_id
    'cache_profile' => 'profile_%s_%s', // app_id,user_id
    'cache_app_user_push' => 'app_user_push_%s', // app_id
    'cache_news_detail' => 'news_detail_%s_%s', // app_id,id
    'cache_coupons_detail' => 'coupons_%s_%s', // app_id,id
    'cache_app_domain' => 'app_by_domain_%s', // domain
    'cache_app_secret_info' => 'app_secret_info_%s', // app_id

    'noti_google_url' => 'https://fcm.googleapis.com/fcm/send',
    'noti_apple_url' => 'ssl://gateway.sandbox.push.apple.com:2195',
    'noti_web_url' => 'https://android.googleapis.com/gcm/send',
    'redis_chanel_notification' => 'notification_mobile',

    'cache_staff' => 'staff_%s_%s_%s_%s', // app_id,category_id,pageindex,pagesize
    'cache_staff_detail' => 'staff_detail_%s_%s', // app_id,id
    'cache_staff_categories' => 'staff_categories_%s_%s', // app_id,menu_id

    'secret_key_for_domain' => 'Tenposs@123',
    'secret_key_coupon_use' => 'ASDFghjkl@12345A',
    'url_open_coupon_code' => 'https://ten-po.com/coupon/use/code/%s/%s/%s/%s',

    'path_host_apache_site_available' => '/etc/apache2/sites-available/',
    //notification configure
    'url_upload_file_notification_configure' => 'https://apinotification.ten-po.com/v1/configure_notification',
    'url_get_notification_configure' => 'https://apinotification.ten-po.com/v1/get_configure/',
];