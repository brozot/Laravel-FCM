<?php namespace LaravelFCM\Response;


use LaravelFCM\Message\Message;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


class Response {

	protected $numberSuccess = 0;
	protected $numberFailure = 0;
	protected $numberCanonicalId = 0;

	protected $multicastId = 0;

	protected $tokenToDelete = [];
	protected $tokenToModify = [];

	protected $message;

	public function __construct(array $response, Message $message)
	{
		$this->message = $message;
		$this->response =$response;
		$this->parse();
		$this->logResults();
	}

	private function parse()
	{
		$this->numberSuccess = $this->response['success'];
		$this->numberFailure = $this->response['failure'];
		$this->numberCanonicalId = $this->response['canonical_ids'];

		if ($this->numberFailure != 0 || $this->numberCanonicalId != 0) {
			$this->parseResult();
		}
	}

	private function parseResult()
	{
		$tokens = $this->message->getTokens();

		foreach ($this->response['results'] as $index=>$result) {
			if (array_key_exists('message_id', $result) && (array_key_exists('registration_id', $result))) {
				array_add($this->tokenToModify, $tokens[$index], $result['registration_id']);
			}
			else if (array_key_exists('error', $result)) {
				if (in_array('NotRegistered', $result) || in_array('InvalidRegistration', $result)) {
					array_push($this->tokenToDelete, $tokens[$index]);
				}
			}
		}
	}

	public function numberSuccess()
	{
		return $this->numberSuccess;
	}

	public function numberFailure()
	{
		return $this->numberFailure;
	}

	public function numberModifiedToken()
	{
		return $this->numberCanonicalId;
	}

	public function tokenToDelete()
	{
		return $this->tokenToDelete;
	}

	public function tokenToModify()
	{
		return $this->tokenToModify;
	}

	private function logResults()
	{
		$logger = new Logger('Laravel-FCM');
		$logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

		$logMessage =  "notification send to ".count($this->message->getTokens())." devices".PHP_EOL;
		$logMessage .= "success: ".$this->numberSuccess.PHP_EOL;
		$logMessage .= "failures: ".$this->numberFailure.PHP_EOL;
		$logMessage .= "number of modified token : ".$this->numberCanonicalId.PHP_EOL;
		$logMessage .= "canonical_ids : ".implode("|", $this->tokenToModify).PHP_EOL;

		$logger->info($logMessage);
	}

}
