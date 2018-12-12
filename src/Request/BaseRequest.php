<?php

namespace LaravelFCM\Request;

/**
 * Class BaseRequest.
 */
abstract class BaseRequest
{
    /**
     * @internal
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @internal
     *
     * @var array
     */
    protected $config;

    /**
     * BaseRequest constructor.
     */
    public function __construct()
    {
        $this->config = app('config')->get('fcm.http', []);
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildRequestHeader()
    {
        return [
            'Authorization' => 'key='.$this->config['server_key'],
            'Content-Type' => 'application/json',
            'project_id' => $this->config['sender_id'],
        ];
    }

    /**
     * Build the body of the request.
     *
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build()
    {
        return [
            'headers' => $this->buildRequestHeader(),
            'json' => $this->buildBody(),
        ];
    }

    /**
     * Overwrites the server_key and sender_id that is in the .env file.
     * This allows for multiple senders. If your application supports multiple users/clients, and each client sends its
     * own notifications, each one has it's own sender_id (and key), so you can save it in the database.
     *
     * @param $server_key
     * @param $sender_id
     */
    public function overwriteServerKeyAndSenderId($server_key, $sender_id)
    {
        $this->config['server_key'] = $server_key;
        $this->config['sender_id'] = $sender_id;
    }
}
