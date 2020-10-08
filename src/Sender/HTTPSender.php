<?php

namespace LaravelFCM\Sender;

use GuzzleHttp\ClientInterface;
use Monolog\Logger;

abstract class HTTPSender
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
     * The logger.
     *
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * Initializes a new sender object.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string                     $url
     */
    public function __construct(ClientInterface $client, $url, Logger $logger)
    {
        $this->client = $client;
        $this->url = $url;
        $this->logger = $logger;
    }
}
