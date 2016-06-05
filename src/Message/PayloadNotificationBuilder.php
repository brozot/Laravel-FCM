<?php namespace LaravelFCM\Message;


class PayloadNotificationBuilder {

	protected $title;
	protected $body;
	protected $icon;
	protected $sound;
	protected $badge;
	protected $tag;
	protected $color;
	protected $clickAction;
	protected $bodyLocationKey;
	protected $bodyLocationArgs;
	protected $titleLocationKey;
	protected $titleLocationArgs;

	/**
	 * Official google documentation :
	 * @link http://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
	 *
	 * Title must be present on android notification and ios (watch) notification
	 *
	 * @param String $title
	 */
	public function __construct($title = null)
	{
		$this->title = $title;
	}

	/**
	 * Indicates notification title. This field is not visible on iOS phones and tablets.
	 * but it is required for android
	 *
	 * @param String $title
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Indicates notification body text.
	 *
	 * @param String $body
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setBody($body)
	{
		$this->body = $body;

		return $this;
	}

	/**
	 * Supported Android
	 * Indicates notification icon. example : Sets value to myicon for drawable resource myicon.
	 *
	 * @param String $icon
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setIcon($icon)
	{
		$this->icon = $icon;

		return $this;
	}

	/**
	 * Indicates a sound to play when the device receives a notification.
	 * Supports default or the filename of a sound resource bundled in the app.
	 *
	 * @param String $sound
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setSound($sound)
	{
		$this->sound = $sound;

		return $this;
	}

	/**
	 * Supported Ios
	 *
	 * Indicates the badge on the client app home icon.
	 *
	 * @param String $badge
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setBadge($badge)
	{
		$this->badge = $badge;

		return $this;
	}

	/**
	 * Supported Android
	 *
	 * Indicates whether each notification results in a new entry in the notification drawer on Android.
	 * If not set, each request creates a new notification.
	 * If set, and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.
	 *
	 * @param String $tag
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;

		return $this;
	}

	/**
	 * Supported Android
	 *
	 * Indicates color of the icon, expressed in #rrggbb format
	 *
	 * @param String $color
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setColor($color) {
		$this->color = $color;

		return $this;
	}

	/**
	 * Indicates the action associated with a user click on the notification
	 *
	 * @param String $action
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setClickAction($action)
	{
		$this->clickAction = $action;

		return $this;
	}

	/**
	 * Indicates the key to the title string for localization.
	 *
	 * @param String $titleKey
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setTitleLocationKey($titleKey)
	{
		$this->titleLocationKey = $titleKey;

		return $this;
	}

	/**
	 * Indicates the string value to replace format specifiers in the title string for localization.
	 *
	 * @param mixed $titleArgs
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setTitleLocationArgs($titleArgs)
	{
		$this->titleLocationArgs = $titleArgs;

		return $this;
	}

	/**
	 * Indicates the key to the body string for localization.
	 *
	 * @param String $bodyKey
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setBodyLocationKey($bodyKey)
	{
		$this->bodyLocationKey = $bodyKey;

		return $this;
	}

	/**
	 * Indicates the string value to replace format specifiers in the body string for localization.
	 *
	 * @param mixed $bodyArgs
	 *
	 * @return PayloadNotificationBuilder current instance of the builder
	 */
	public function setBodyLocationArgs($bodyArgs)
	{
		$this->bodyLocationArgs = $bodyArgs;

		return $this;
	}

	/**
	 * @return null|String
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return null|String
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @return null|String
	 */
	public function getIcon()
	{
		return $this->icon;
	}

	/**
	 * @return null|String
	 */
	public function getSound()
	{
		return $this->sound;
	}

	/**
	 * @return null|String
	 */
	public function getBadge()
	{
		return $this->badge;
	}

	/**
	 * @return null|String
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @return null|String
	 */
	public function getColor()
	{
		return $this->color;
	}

	/**
	 * @return null|String
	 */
	public function getClickAction()
	{
		return $this->clickAction;
	}

	/**
	 * @return null|String
	 */
	public function getBodyLocationKey()
	{
		return $this->bodyLocationKey;
	}

	/**
	 * @return null|String|array
	 */
	public function getBodyLocationArgs()
	{
		return $this->bodyLocationArgs;
	}

	/**
	 * @return string
	 */
	public function getTitleLocationKey()
	{
		return $this->titleLocationKey;
	}

	/**
	 * @return null|String|array
	 */
	public function getTitleLocationArgs()
	{
		return $this->titleLocationArgs;
	}
	
	

	/**
	 * Build an PayloadNotification
	 * 
	 * @return PayloadNotification
	 */
	public function build()
	{
		return new PayloadNotification($this);
	}
}