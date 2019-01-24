<?php

namespace LaravelFCM\Sender;

use GuzzleHttp\ClientInterface;
use LaravelFCM\Request\BaseRequest;

/**
 * Class BaseSender.
 */
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
     * Default request options 
     * 
     * @var array
     */
    protected $config;

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

        $this->configureDefaults();
    }

    /**
     * Configures the default options for a client.
     * 
     */
    private function configureDefaults()
    {
        $this->config = app('config')->get('fcm.default', []);
    }

    /**
     * Merges default options into the array.
     * 
     * @param mixed     $options
     * 
     * @return array
     */
    private function perpareDefaults($options)
    {
        $defaults = $this->config;

        if (is_string($options)) {
            $options = app('config')->get('fcm.' . $options, []);
        }

        if (is_array($options)) {
            $defaults = array_merge($defaults, $options);
        }

        return $defaults;
    }

    /**
     * Build the options of the request.
     * 
     * @param array     $options
     * 
     * @return array
     */
    private function buildConfig(array $options)
    {
        return array_filter([
            'headers' => $this->buildRequestHeader($options),
            'proxy' => $options['proxy'],
            'timeout' => $options['timeout'],
        ]);
    }

    /**
     * Build the headers for the request.
     * 
     * @param array     $options
     * 
     * @return array
     */
    private function buildRequestHeader(array $options)
    {
        return [
            'Authorization' => 'key=' . $options['server_key'],
            'Content-Type' => 'application/json',
            'project_id' => $options['sender_id'],
        ];
    }

    /**
     * send a request with the options
     * 
     * @param \LaravelFCM\Request\BaseRequest   $request
     * @param mixed     $options
     * 
     * @return  Psr\Http\Message\ResponseInterface
     */
    protected function send(BaseRequest $request, $options)
    {
        $options = $this->perpareDefaults($options);
        $options = array_merge($this->buildConfig($options), $request->build());

        try {
            $response = $this->client->request('post', $this->url, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }
}
