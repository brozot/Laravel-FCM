<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool validateToken(string $token)
 */
class FCMValidator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.validator';
    }
}
