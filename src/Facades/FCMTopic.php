<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

class FCMTopic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.topic';
    }
}
