<?php

namespace LaravelFCM\Getter;

use LaravelFCM\Request\Request;
use GuzzleHttp\Exception\ClientException;
use LaravelFCM\Sender\HTTPSender;

/**
 * Class FCMGetter.
 */
class FCMGetter extends HTTPGetter
{

    /**
     * get the device type by his token.
     *
     * [ANDROID , IOS , BROWSER]
     *
     * @param string $token
     *
     * @return string|null
     */
    public function getDeviceType($token = '')
    {
        $header = $this->buidAppInstancesHeader();
        $responseGuzzle = $this->client->request('post', "$this->url/$token", $header);
        // get body of this response
        $content = $responseGuzzle->getBody()->getContents();
        $result = json_decode($content);
        return $result->platform;
    }
}
