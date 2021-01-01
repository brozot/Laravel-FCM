<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method LaravelFCM\Facades\Getter\FCMGetter getDeviceType(string $token)
 */
class FCMGetter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.getter';
    }
}
