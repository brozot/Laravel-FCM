<?php namespace LaravelFCM;

use Exception;
use LaravelFCM\Message\Message;
use LaravelFCM\Response\Response;

class FCM implements NetworkClient {

	protected $client;

	public function __construct()
	{
		$this->client = app('fcm.client');
	}

	public function send(Message $message)
	{
		//url registered with the client
		$response = $this->client->post('', $this->buildData($message));
		if ($response->getStatusCode() != 200) {
			throw new ResponseCodeException('Response with code: '.$response->getStatusCode());
		}

		$json = json_decode($response->getBody(), true);

		return new Response($json, $message);
	}

	protected function buildData($message)
	{
		return [
			'headers' => $this->buildHeader(),
			'json' => $message->toArray()
		];
	}

	protected function buildHeader()
	{
		return [
			'Authorization' => 'key='.config('fcm.http.server_key'),
			'Content-Type' => "application/json"
		];
	}
}

class ResponseCodeException extends Exception {}