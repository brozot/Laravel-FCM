<?php namespace LaravelFCM\Downstream;


use LaravelFCM\FCMRequest;
use LaravelFCM\Group\DownstreamResponse;
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

		$this->sendRequest();
	}

	protected function getUrl()
	{
		return $this->config['server_send_url'];
	}

	protected function constructResponse(Response $response)
	{
		return new DownstreamResponse($response);
	}
}