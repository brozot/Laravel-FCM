<?php namespace LaravelFCM\Group;

use LaravelFCM\FCMRequest;
use LaravelFCM\Message\Options;
use LaravelFCM\Message\PayloadData;
use LaravelFCM\Message\PayloadNotification;
use GuzzleHttp\Psr7\Response;

class FCMGroup extends FCMRequest{

	public function sendWithNotificationKey($notificationKey, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$this->to = $notificationKey;
		$this->options = $options;
		$this->notification = $notification;
		$this->data = $data;

		$this->sendRequest();
	}


	public function createGroup($notificationKeyName, array $registeredId)
	{
		$url = $this->getUrl();
		$response = $this->client->post($url, $this->buildGroupRequest('create', $notificationKeyName, $registeredId));

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	public function addToGroup($notificationKeyName, $notificationKey, array $registeredId)
	{
		$url = $this->getUrl();
		$response = $this->client->post($url, $this->buildGroupRequest('add', $notificationKeyName, $registeredId, $notificationKey));

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	public function removeFromGroup($notificationKeyName, $notificationKey, array $registeredId)
	{
		$url = $this->getUrl();
		$response = $this->client->post($url, $this->buildGroupRequest('remove', $notificationKeyName, $registeredId, $notificationKey));

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

	protected function constructResponse(Response $response)
	{
		return new GroupResponse($response, $this->to);
	}

	protected function buildGroupRequest($operation, $notificationKeyName, array $registrationIds, $notificationKey = null)
	{
		return [
			'header' => $this->buildRequestHeader(),
			'json' => $this->buildGroupRequestData($operation, $notificationKeyName, $registrationIds, $notificationKey)
		];
	}

	protected function buildGroupRequestData($operation, $notificationKeyName, array $registrationIds, $notificationKey = null)
	{
		return [
			'operation' => $operation,
			'notification_key_name' => $notificationKeyName,
			'notification_key' => $notificationKey,
			'registration_ids' => array_values($registrationIds)
		];
	}

	/**
	 * @param $response
	 *
	 * @return bool
	 */
	public function isValidResponse($response)
	{
		return $response->getReasonPhrase() != 'OK' || $response->getStatusCode() != 200;
}
}