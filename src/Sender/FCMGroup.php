<?php

namespace LaravelFCM\Sender;

use LaravelFCM\Request\GroupRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Class FCMGroup.
 */
class FCMGroup extends HTTPSender
{
    const CREATE = 'create';
    const ADD = 'add';
    const REMOVE = 'remove';

    /**
     * Create a group.
     *
     * @param       $notificationKeyName
     * @param array $registrationIds
     * @param array|string|null        $httpConfig
     * @return null|string notification_key
     */
    public function createGroup($notificationKeyName, array $registrationIds, $httpConfig = null)
    {
        $request = new GroupRequest(self::CREATE, $notificationKeyName, null, $registrationIds);

        $response = $this->send($request, $httpConfig);

        return $this->getNotificationToken($response);
    }

    /**
     * add registrationId to a existing group.
     *
     * @param       $notificationKeyName
     * @param       $notificationKey
     * @param array $registrationIds     registrationIds to add
     * @param array|string|null        $httpConfig
     * 
     * @return null|string notification_key
     */
    public function addToGroup($notificationKeyName, $notificationKey, array $registrationIds, $httpConfig = null)
    {
        $request = new GroupRequest(self::ADD, $notificationKeyName, $notificationKey, $registrationIds);
        $response = $this->send($request, $httpConfig);

        return $this->getNotificationToken($response);
    }

    /**
     * remove registrationId to a existing group.
     *
     * >Note: if you remove all registrationIds the group is automatically deleted
     *
     * @param       $notificationKeyName
     * @param       $notificationKey
     * @param array $registeredIds       registrationIds to remove
     * @param array|string|null        $httpConfig
     * 
     * @return null|string notification_key
     */
    public function removeFromGroup($notificationKeyName, $notificationKey, array $registeredIds, $httpConfig = null)
    {
        $request = new GroupRequest(self::REMOVE, $notificationKeyName, $notificationKey, $registeredIds);
        $response = $this->send($request, $httpConfig);

        return $this->getNotificationToken($response);
    }

    /**
     * @internal
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return null|string notification_key
     */
    private function getNotificationToken(ResponseInterface $response)
    {
        if (!$this->isValidResponse($response)) {
            return null;
        }

        $json = json_decode($response->getBody()->getContents(), true);

        return $json['notification_key'];
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function isValidResponse(ResponseInterface $response)
    {
        return $response->getStatusCode() === 200;
    }
}
