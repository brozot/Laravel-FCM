<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaravelFCM\Response\GroupResponse sendToGroup(string|string[] $notificationKey, Options|null $options, PayloadNotification|null $notification, PayloadData|null $data)
 */
class FCM extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.sender';
    }
}
