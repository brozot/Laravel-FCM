<?php

namespace LaravelFCM\Getter;

use GuzzleHttp\ClientInterface;

/**
 * Class HTTPGetter.
 */
abstract class HTTPGetter
{
    /**
     * The client used to send messages.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * The URL entry point.
     *
     * @var string
     */
    protected $url;

    /**
     * Initializes a new sender object.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string                     $url
     */
    public function __construct(ClientInterface $client, $url)
    {
        $this->client = $client;
        $this->url = $url;
    }
    /**
     * build the app instance required header.
     * for more details see : https://developers.google.com/instance-id/reference/server
     * @return array
     */
    public function buildAppInstancesHeader()
    {
        $header = [
            "Content-Type" => "application/json",
            'Accept' => 'application/json',
            "Authorization" => "bearer " . env('FCM_SERVER_KEY')];

        return ['headers' => $header];
    }
}
