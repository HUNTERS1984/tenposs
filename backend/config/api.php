<?php

return [
    'cache_delete_news' => 'news_%s_%s', //app_id,store_id
    'cache_delete_items' => 'items_%s', // app_id
    'cache_delete_menus' => 'menus_%s', // app_id
    'cache_delete_photo_cat' => 'photo_cat_%s_%s', // app_id,store_id
    'cache_delete_photos' => 'photos_%s_%s', // app_id,category_id
    'cache_delete_reserve' => 'reserve_%s_%s', // app_id,store_id
    'cache_delete_app_detail' => 'app_detail_%s', // app_id
    'cache_delete_app_detail_token' => 'app_detail_token_%s', // token
    'cache_delete_app_info' => 'app_info_%s', // app_id
    'cache_delete_coupons' => 'coupon_%s', // app_id
    'cache_delete_top_images' => 'top_images_%s', // app_id
    'cache_delete_top_news' => 'top_news_%s', // app_id
    'cache_delete_top_photos' => 'top_photos_%s', // app_id
    'cache_delete_top_items' => 'top_items_%s', // app_id
    'cache_delete_top_contacts' => 'top_contacts_%s', // app_id
    'cache_delete_profile' => 'profile_%s', // app_id
    'cache_delete_app_user_push' => 'app_user_push_%s', // app_id

    'noti_google_url' => 'https://fcm.googleapis.com/fcm/send',
    'noti_apple_url' => 'ssl://gateway.sandbox.push.apple.com:2195',
    'redis_chanel_notification' => 'notification_mobile',

    'cache_delete_staff' => 'staff_%s_%s_%s_%s', // app_id,category_id,pageindex,pagesize
    'cache_delete_staff_categories' => 'staff_categories_%s_%s', // app_id,menu_id

    'url_api_notification_app_id' => 'https://api.ten-po.com/api/v1/notification_app_id',
    'url_api_notification_app_user_id' => 'https://api.ten-po.com/api/v1/notification',


    'secret_key_coupon_use' => 'ASDFghjkl@12345A',
    'url_open_coupon_code' => 'https://ten-po.com/coupon/use/code/%s/%s',
];