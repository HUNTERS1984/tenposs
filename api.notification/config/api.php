<?php
return [
    'redis_chanel_notification' => 'notification_center',
    'noti_google_url' => 'https://fcm.googleapis.com/fcm/send',
    'noti_apple_url' => 'ssl://gateway.sandbox.push.apple.com:2195',
    'noti_web_url' => 'https://android.googleapis.com/gcm/send',
    'media_base_url' => 'https://ten-po.com/',
    'url' => 'https://api.ten-po.com/api/v1/',
    'url_v2' => 'https://api.ten-po.com/api/v2/',
    'sig_news_detail' => array('app_id', 'time', 'id'),
    'sig_coupon_detail' => array('app_id', 'time', 'id'),
    'sig_app_secret_info' => array('app_id', 'time'),
    'sig_get_auth_user_from_app_user_id' => array('app_id', 'time', 'app_user_id'),
];