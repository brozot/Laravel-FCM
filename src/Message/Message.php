<?php namespace LaravelFCM\Message;


use Illuminate\Contracts\Support\Arrayable;

/**
 * Form more information about options, please refer to google official documentation :
 * @link http://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
 */
class Message implements Arrayable {

	protected $to;
	protected $registrationIds;
	protected $options;
	protected $notification;
	protected $data;

	protected $conditions;

	private function __construct($to = null, $registrationId = null, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$this->to = $to;
		$this->registrationIds = $registrationId;
		$this->options = $options;
		$this->notification = $notification;
		$this->data = $data;
	}

	/**
	 * Create a message which send to a registration token, notification key, or topic.
	 * The value must be a registration token, notification key, or topic.
	 * Do not set this field when sending to multiple topics. See condition.
	 *
	 * @param                          $to
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
*@return static
	 */
	public static function createWithTo($to, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null){
		return new static($to, null, $options, $notification, $data);
	}

	/**
	 * Create a message for multicasting
	 *
	 * @param                          $registrationId
	 * @param Options|null             $options
	 * @param PayloadNotification|null $notification
	 * @param PayloadData|null         $data
	 *
	 * @return static
	 */
	public static function createWithRegistrationIds($registrationId, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null){
		return new static(null, $registrationId, $options, $notification, $data);
	}

	/**
	 * This parameter specifies a logical expression of conditions that determine the message target.
	 *
	 * @param $conditions
	 */
	public function setCondition($conditions)
	{
		$this->conditions = $conditions;
	}

	public function getTokens()
	{
		if (!empty($this->to)) {
			return $this->to;
		}

		if (!empty($this->registrationIds)) {
			return $this->registrationIds;
		}

		return [];
	}

	function toArray()
	{
		$notification = $this->notification ? $this->notification->toArray() : null;
		$data = $this->data ? $this->data->toArray() : null;

		$message = [
			'to' => $this->to,
		    'registration_ids' => $this->registrationIds,
		    'condition' => $this->conditions,
		    'notification' => $notification,
			'data' => $data
		];

		if ($this->options) {
			$message = array_merge($message, $this->options->toArray());
		}

		// remove null fields
		$message = array_filter($message);

		return $message;
	}
}