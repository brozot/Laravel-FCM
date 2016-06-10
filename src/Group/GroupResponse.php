<?php namespace LaravelFCM\Group;


use GuzzleHttp\Psr7\Response;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class GroupResponse {

	const SUCCESS = 'success';
	const FAILURE = 'failure';
	const FAILED_REGISTRATION_IDS = 'failed_registration_ids';

	protected $numberOfSuccess = 0;
	protected $numberOfFailure = 0;

	protected $invalidNotificationKey = null;
	protected $failedTokens = [];

	public function __construct(Response $response, $notificationKey)
	{
		// Todo remove that
		dd($response->getReasonPhrase());

		if ($this->CheckIfNotificationIsValid($response, $notificationKey)) {
			$json = json_decode($response->getBody(), true);
			$this->parseResponse($json);
			$this->logResult($notificationKey);
		};
	}


	private function parseResponse($json)
	{
		if (array_key_exists(self::SUCCESS, $json)) {
			$this->numberOfSuccess = $json[self::SUCCESS];
		}

		if (array_key_exists(self::FAILURE, $json)) {
			$this->numberOfFailure = $json[self::FAILURE];
		}

		if (array_key_exists(self::FAILED_REGISTRATION_IDS, $json)) {
			$this->failedTokens = $json[self::FAILED_REGISTRATION_IDS];
		}
	}

	public function numberSuccess()
	{
		return $this->numberOfSuccess;
	}

	public function numberFailure()
	{
		return $this->numberOfFailure;
	}

	public function invalidNotificationKey()
	{
		return $this->invalidNotificationKey;
	}

	/**
	 * @param $response
	 * @param $notificationKey
	 *
	 * @return bool
	 */
	private function CheckIfNotificationIsValid($response, $notificationKey)
	{
		if ($response->getReasonPhrase() == 'NotRegistered') {
			$this->invalidNotificationKey = $notificationKey;
			$this->logError();
			return false;
		}

		return true;
	}

	protected function logResult($notificationKey)
	{
		$logger = new Logger('Laravel-FCM');
		$logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

		$logMessage =  "notification send group id ".$notificationKey." ";
		$logMessage .= "with ".$this->numberOfSuccess." success ";
		$logMessage .= "and ".$this->numberOfFailure." failures ";

		$logger->info($logMessage);
	}

	protected function logError()
	{
		$logger = new Logger('Laravel-FCM');
		$logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

		$logMessage =  "notification cannot be sent to group id ".$this->invalidNotificationKey;

		$logger->info($logMessage);
	}

}