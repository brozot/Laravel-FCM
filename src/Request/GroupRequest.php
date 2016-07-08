<?php namespace LaravelFCM\Request;


class GroupRequest extends BaseRequest{

	protected $client;
	protected $config;

	protected $operation;
	protected $notificationKeyName;
	protected $notificationKey;
	protected $registrationIds;

	/**
	 * GroupRequest constructor.
	 *
	 * @param $operation
	 * @param $notificationKeyName
	 * @param $notificationKey
	 * @param $registrationIds
	 */
	public function __construct($operation, $notificationKeyName, $notificationKey, $registrationIds)
	{
		parent::__construct();

		$this->operation = $operation;
		$this->notificationKeyName = $notificationKeyName;
		$this->notificationKey = $notificationKey;
		$this->registrationIds = $registrationIds;
	}

	/**
	 * Build the header for the request
	 *
	 * @return array
	 */
	protected function buildBody()
	{
		return [
			'operation'             => $this->operation,
			'notification_key_name' => $this->notificationKeyName,
			'notification_key'      => $this->notificationKey,
			'registration_ids'      => $this->registrationIds
		];
	}
}