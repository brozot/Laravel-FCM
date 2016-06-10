<?php namespace LaravelFCM;

use GuzzleHttp\Psr7\Response;

abstract class FCMRequest {

	protected $client;
	protected $config;

	protected $to;
	protected $registrationIds;
	protected $options;
	protected $notification;
	protected $data;

	protected $conditions;

	public function __construct()
	{
		$this->client = app('fcm.client');
		$this->config = app('config')->get('fcm.http', []);
	}

	protected function sendRequest()
	{
		$url = $this->getUrl();
		$response = $this->client->post($url, $this->buildRequest());

		return $this->constructResponse($response);
	}

	protected abstract function getUrl();
	protected abstract function constructResponse(Response $json);

	protected  function buildRequest()
	{
		return [
			'headers' => $this->buildHeader(),
			'json' => $this->buildRequestData()
		];
	}

	protected function buildRequestData()
	{
		$notification = $this->notification ? $this->notification->toArray() : null;
		$data = $this->data ? $this->data->toArray() : null;

		$message = [
			'to'               => $this->to,
			'registration_ids' => $this->registrationIds,
			'condition'        => $this->conditions,
			'notification'     => $notification,
			'data'             => $data
		];

		if ($this->options) {
			$message = array_merge($message, $this->options->toArray());
		}

		$message = array_filter($message);

		return $message;
	}

	protected function buildRequestHeader()
	{
		return [
			'Authorization' => $this->config['server_key'],
			'Content-Type' => "application/json",
			'project_id' => $this->config['sender_id']
		];
	}

}