<?php
namespace LaravelFCM\Events;

use LaravelFCM\Message\Options;
use LaravelFCM\Message\PayloadData;
use LaravelFCM\Message\PayloadNotification;

class Resend
{
	public
		/**@var string**/
		$token,
        $options = null,
        $notification = null,
        $data = null;

    /**
     * Resend constructor.
     * @param string $token Destination token that should be resended
     * @param Options|null $options
     * @param PayloadNotification|null $notification
     * @param PayloadData|null $data
     */
    public function __construct(string $token, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
    {
		$this->token = $token;
		$this->options = $options;
		$this->notification = $notification;
		$this->data = $data;
    }
}