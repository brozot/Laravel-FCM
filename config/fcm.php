<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,       

    'http' => [
        'timeout' => 30.0, // in second
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',     
        'key_1' => [
            'server_key' => env('FCM_SERVER_KEY', 'Your FCM server key'),
            'sender_id' => env('FCM_SENDER_ID', 'Your sender id')                
        ],
        'key_2' => [
            'server_key' => env('FCM_SERVER_KEY', 'Your FCM server key'),
            'sender_id' => env('FCM_SENDER_ID', 'Your sender id')                
        ]
    ],
];
