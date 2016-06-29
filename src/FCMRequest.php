<?php namespace LaravelFCM;

abstract class FCMRequest {

	protected $client;
	protected $config;

	protected $conditions;

	public function __construct()
	{
		$this->client = app('fcm.client');
		$this->config = app('config')->get('fcm.http', []);
	}

	protected function buildRequestHeader()
	{
		return [
			'Authorization' => "key=".$this->config['server_key'],
			'Content-Type' => "application/json",
			'project_id' => $this->config['sender_id']
		];
	}
}