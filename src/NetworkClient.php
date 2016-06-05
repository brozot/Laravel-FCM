<?php namespace LaravelFCM;

use LaravelFCM\Message\Message;

interface NetworkClient {

	public function send(Message $message);

}