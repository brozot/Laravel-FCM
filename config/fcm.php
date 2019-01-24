<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
    'server_group_url' => 'https://android.googleapis.com/gcm/notification',

    'default' => [
        'server_key' => env('FCM_DEFAULT_SERVER_KEY', 'Your FCM server key'),
        'sender_id' => env('FCM_DEFAULT_SENDER_ID', 'Your sender id'),
        'timeout' => 30.0, // in second
        'proxy' => env('FCM_DEFAULT_PROXY', ''),
    ],
];
