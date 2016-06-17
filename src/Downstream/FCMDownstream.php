<?php namespace LaravelFCM\Downstream;


use LaravelFCM\FCMRequest;
use LaravelFCM\Group\DownstreamResponse;
use LaravelFCM\Group\GroupResponse;
use LaravelFCM\Message\Options;
use LaravelFCM\Message\PayloadData;
use LaravelFCM\Message\PayloadNotification;
use \GuzzleHttp\Psr7\Response;

class FCMDownstream extends FCMRequest {

	public function sendTo($to, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$this->to = $to;
		$this->options = $options;
		$this->notification = $notification;
		$this->data = $data;

		$response = $this->sendRequest();
		return $this->constructResponse($response);
	}

	public function sendWithNotificationKey($notificationKey, Options $options = null, PayloadNotification $notification = null, PayloadData $data = null)
	{
		$this->to = $notificationKey;
		$this->options = $options;
		$this->notification = $notification;
		$this->data = $data;

		$response = $this->sendRequest();
		return $this->constructGroupResponse($response);
	}

	protected function getUrl()
	{
		return $this->config['server_send_url'];
	}

	protected function constructResponse(Response $response)
	{
		return new DownstreamResponse($response);
	}

	protected function constructGroupResponse($response)
	{
		return new GroupResponse($response, $this->to);
	}
}