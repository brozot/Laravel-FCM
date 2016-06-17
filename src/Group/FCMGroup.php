<?php namespace LaravelFCM\Group;

use LaravelFCM\FCMRequest;

class FCMGroup extends FCMRequest{

	protected $operation;
	protected $notificationKeyName;
	protected $notificationKey;
	protected $notification;

	public function createGroup($notificationKeyName, array $registrationIds)
	{
		$this->operation = "create";
		$this->notificationKeyName = $notificationKeyName;
		$this->registrationIds = $registrationIds;

		$response = $this->sendRequest();

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	public function addToGroup($notificationKeyName, $notificationKey, array $registrationIds)
	{
		$this->operation = "add";
		$this->notificationKeyName = $notificationKeyName;
		$this->notificationKey = $notificationKey;
		$this->registrationIds = $registrationIds;

		$response = $this->sendRequest();

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	public function removeFromGroup($notificationKeyName, $notificationKey, array $registeredId)
	{
		$this->operation = "remove";
		$this->notificationKeyName = $notificationKeyName;
		$this->notificationKey = $notificationKey;
		$this->registrationIds = $registeredId;

		$response = $this->sendRequest();

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	protected function getUrl()
	{
		return $this->config['server_group_url'];
	}


	protected function buildRequestData()
	{
		return [
			'operation'             => $this->operation,
			'notification_key_name' => $this->notificationKeyName,
			'notification_key'      => $this->notificationKey,
			'registration_ids'      => $this->notification
		];
	}


	public function isValidResponse($response)
	{
		return $response->getReasonPhrase() != 'OK' || $response->getStatusCode() != 200;
	}
}