<?php namespace LaravelFCM\Group;

use LaravelFCM\FCMRequest;

class FCMGroup extends FCMRequest{


	const CREATE = "create";
	const ADD = "add";
	const REMOVE = "remove";

	public function createGroup($notificationKeyName, array $registrationIds)
	{
		$url = $this->config['server_group_url'];
		$data = $this->buildRequest(self::CREATE, $notificationKeyName, null, $registrationIds);

		$response = $this->client->post($url, $data);

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	public function addToGroup($notificationKeyName, $notificationKey, array $registrationIds)
	{
		$url = $this->config['server_group_url'];
		$data = $this->buildRequest(self::ADD, $notificationKeyName, $notificationKey, $registrationIds);

		$response = $this->client->post($url, $data);

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	public function removeFromGroup($notificationKeyName, $notificationKey, array $registeredIds)
	{
		$url = $this->config['server_group_url'];
		$data = $this->buildRequest(self::REMOVE, $notificationKeyName, $notificationKey, $registeredIds);

		$response = $this->client->post($url, $data);

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	protected  function buildRequest($operation, $notificationKeyName, $notificationKey, array $registrationIds)
	{
		return [
			'headers' => $this->buildRequestHeader(),
			'json' => $this->buildRequestData($operation, $notificationKeyName, $notificationKey, $registrationIds)
		];
	}

	protected function buildRequestData($operation, $notificationKeyName, $notificationKey, array $registrationIds)
	{
		return [
			'operation'             => $operation,
			'notification_key_name' => $notificationKeyName,
			'notification_key'      => $notificationKey,
			'registration_ids'      => $registrationIds
		];
	}


	public function isValidResponse($response)
	{
		return $response->getReasonPhrase() != 'OK' || $response->getStatusCode() != 200;
	}
}