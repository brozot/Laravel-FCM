<?php namespace LaravelFCM;

use Exception;
use LaravelFCM\Message\Message;
use LaravelFCM\Response\Response;

class FCM implements NetworkClient {

	const OPERATION_CREATE = 'create';
	const OPERATION_ADD = 'add';
	const OPERATION_REMOVE = 'remove';

	protected $config;
	protected $client;

	public function __construct()
	{
		$this->client = app('fcm.client');
		$this->config = app('config')->get('fcm.http', []);
	}

	public function send(Message $message)
	{
		$url = $this->config['server_send_url'];
		//url registered with the client
		$response = $this->client->post($url, $this->buildData($message));
		if ($response->getStatusCode() != 200) {
			throw new ResponseCodeException('Response with code: '.$response->getStatusCode());
		}

		$json = json_decode($response->getBody(), true);

		return new Response($json, $message);
	}

	public function createGroup($notificationKeyName, array $registrationIds)
	{
		$url = $this->config['server_group_url'];

		return $this->client->post($url, $this->buildGroupCreationData(self::OPERATION_CREATE, $notificationKeyName, $registrationIds));
	}

	public function addToGroup($notificationKeyName, $notificationKey, array $registrationIds)
	{
		$url = $this->config['server_group_url'];

		return $this->client->post($url, $this->buildGroupCreationData(self::OPERATION_ADD, $notificationKeyName, $registrationIds, $notificationKey));
	}

	public function removeFromGroup($notificationKeyName, $notificationKey, array $registrationIds)
	{
		$url = $this->config['server_group_url'];

		return $this->client->post($url, $this->buildGroupCreationData(self::OPERATION_REMOVE, $notificationKeyName, $registrationIds, $notificationKey));
	}

	protected function buildData($message)
	{
		return [
			'headers' => $this->buildHeader(),
			'json' => $message->toArray()
		];
	}

	private function buildGroupCreationData($operation, $notificationKeyName, array $registrationIds, $notificationKey = null)
	{
		$data = [
			'headers' => $this->buildHeader(),
		    'json' => [
			    'operation' => $operation,
		        'notification_key_name' => $notificationKeyName,
		        'notification_key' => $notificationKey,
		        'registration_ids' => array_values($registrationIds)
		    ]
		];

		return array_filter($data);
	}

	protected function buildHeader()
	{
		return [
			'Authorization' => $this->config['server_key'],
			'Content-Type' => "application/json"
		];
	}


}

class ResponseCodeException extends Exception {}