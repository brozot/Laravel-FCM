<?php

namespace LaravelFCM\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool createTopic(string $topicId, string $registrationId)
 * @method static bool subscribeTopic(string $topicId, array|string $recipientsTokens)
 * @method static bool unsubscribeTopic(string $topicId, array|string $recipientsTokens)
 */
class FCMTopic extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm.topic';
    }
}
