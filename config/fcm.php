<?php

return [
    'driver' => env('FCM_PROTOCOL','http'),

    'http' => [
        'server_key' => env('FCM_SERVER_KEY','Your FCM server key'),
        'server_url' => 'https://fcm.googleapis.com/fcm/send',
        'timeout' => 10.0, // in second
    ]
];
