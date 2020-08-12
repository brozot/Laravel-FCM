<?php

namespace LaravelFCM\Sender;

use LaravelFCM\Message\Topics;
use LaravelFCM\Request\Request;
use LaravelFCM\Message\Options;
use LaravelFCM\Message\PayloadData;
use LaravelFCM\Response\GroupResponse;
use LaravelFCM\Response\TopicResponse;
use GuzzleHttp\Exception\ClientException;
use LaravelFCM\Response\DownstreamResponse;
use LaravelFCM\Message\PayloadNotification;

/**
 * Class FCMSender.
 */
class FCMSender extends HTTPSender
{
    const MAX_TOKEN_PER_REQUEST = 1000;

    /**
     * send a downstream message to.
     *
     * - a unique device with is registration Token
     * - or to multiples devices with an array of registrationIds
     *
     * @param string|array             $to
     * @param Options|null             $options
     * @param PayloadNotification|null $notification
     * @param PayloadData|null         $data
     * @param array|string|null        $httpConfig
     *
     * @return DownstreamResponse|null
     */
    public function sendTo($to, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null, $httpConfig = null)
    {
        $response = null;

        if (is_array($to) && !empty($to)) {
            $partialTokens = array_chunk($to, self::MAX_TOKEN_PER_REQUEST, false);
            foreach ($partialTokens as $tokens) {
                $request = new Request($tokens, $options, $notification, $data);

                $responseGuzzle = $this->send($request, $httpConfig);

                $responsePartial = new DownstreamResponse($responseGuzzle, $tokens);
                if (!$response) {
                    $response = $responsePartial;
                } else {
                    $response->merge($responsePartial);
                }
            }
        } else {
            $request = new Request($to, $options, $notification, $data);
            $responseGuzzle = $this->send($request, $httpConfig);

            $response = new DownstreamResponse($responseGuzzle, $to);
        }

        return $response;
    }

    /**
     * Send a message to a group of devices identified with them notification key.
     *
     * @param                          $notificationKey
     * @param Options|null             $options
     * @param PayloadNotification|null $notification
     * @param PayloadData|null         $data
     * @param array|string|null        $httpConfig
     * 
     * @return GroupResponse
     */
    public function sendToGroup($notificationKey, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null, $httpConfig = null)
    {
        $request = new Request($notificationKey, $options, $notification, $data);

        $responseGuzzle = $this->send($request, $httpConfig);

        return new GroupResponse($responseGuzzle, $notificationKey);
    }

    /**
     * Send message devices registered at a or more topics.
     *
     * @param Topics                   $topics
     * @param Options|null             $options
     * @param PayloadNotification|null $notification
     * @param PayloadData|null         $data
     * @param array|string|null        $httpConfig
     *
     * @return TopicResponse
     */
    public function sendToTopic(Topics $topics, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null, $httpConfig = null)
    {
        $request = new Request(null, $options, $notification, $data, $topics);

        $responseGuzzle = $this->send($request, $httpConfig);

        return new TopicResponse($responseGuzzle, $topics);
    }

    /**
     * @internal
     *
     * @param \LaravelFCM\Request\Request $request
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    protected function post($request)
    {
        try {
            $responseGuzzle = $this->client->request('post', $this->url, $request->build());
        } catch (ClientException $e) {
            $responseGuzzle = $e->getResponse();
        }

        return $responseGuzzle;
    }
}
