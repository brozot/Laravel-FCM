<?php namespace LaravelFCM\Sender;

use LaravelFCM\Request\GroupRequest;

/**
 * Class FCMGroup
 *
 * @package LaravelFCM\Sender
 */
class FCMGroup extends BaseSender {
	
	const CREATE = "create";
	const ADD = "add";
	const REMOVE = "remove";

	/**
	 * Create a group
	 *
	 * @param       $notificationKeyName
	 * @param array $registrationIds
	 *
	 * @return null
	 */
	public function createGroup($notificationKeyName, array $registrationIds)
	{
		$request = new GroupRequest(self::CREATE, $notificationKeyName, null, $registrationIds);
		$response = $this->client->post($this->url, $request);

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	/**
	 * add registrationId to a existing group
	 *
	 * @param       $notificationKeyName
	 * @param       $notificationKey
	 * @param array $registrationIds registrationIds to add
	 *
	 * @return null
	 */
	public function addToGroup($notificationKeyName, $notificationKey, array $registrationIds)
	{
		$request = new GroupRequest(self::ADD, $notificationKeyName, $notificationKey, $registrationIds);
		$response = $this->client->post($this->url, $request);

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	/**
	 * remove registrationId to a existing group
	 *
	 * >Note: if you remove all registrationIds the group is automatically deleted
	 *
	 * @param       $notificationKeyName
	 * @param       $notificationKey
	 * @param array $registeredIds registrationIds to remove
	 *
	 * @return null
	 */
	public function removeFromGroup($notificationKeyName, $notificationKey, array $registeredIds)
	{
		$request = new GroupRequest(self::REMOVE, $notificationKeyName, $notificationKey, $registeredIds);
		$response = $this->client->post($this->url, $request);

		if ($this->isValidResponse($response)) {
			return null;
		}

		$json = json_decode($response->getBody(), true);
		return $json['notification_key'];
	}

	/**
	 * @internal
	 *
	 * @param $response
	 *
	 * @return bool
	 */
	public function isValidResponse($response)
	{
		return $response->getReasonPhrase() != 'OK' || $response->getStatusCode() != 200;
	}

	/**
	 * get the url
	 *
	 * @return string
	 */
	protected function getUrl()
	{
		return $this->config['server_group_url'];
	}
}