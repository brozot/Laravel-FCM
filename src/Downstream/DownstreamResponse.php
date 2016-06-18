<?php namespace LaravelFCM\Downstream;



use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use \GuzzleHttp\Psr7\Response;


class DownstreamResponse {

	protected $numberSuccess = 0;
	protected $numberFailure = 0;
	protected $numberCanonicalId = 0;

	protected $multicastId = 0;

	protected $tokenToDelete = [];
	protected $tokenToModify = [];

	protected $to;

	public function __construct(Response $response, $to)
	{
		$this->to = $to;

		if ($response->getStatusCode() == 200) {
			$this->response = json_decode($response, true);

			$this->parse();
			if ($this->isLoginResult()) {
				$this->logResults();
			}
		}
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
		if (is_array($this->to)) {
			$this->parseMultipleDevices();
		}
		else {
			$this->parseUniqueDevice();
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

		$logMessage =  "notification send to ".count($this->to)." devices".PHP_EOL;
		$logMessage .= "success: ".$this->numberSuccess.PHP_EOL;
		$logMessage .= "failures: ".$this->numberFailure.PHP_EOL;
		$logMessage .= "number of modified token : ".$this->numberCanonicalId.PHP_EOL;
		$logMessage .= "canonical_ids : ".implode("|", $this->tokenToModify).PHP_EOL;

		$logger->info($logMessage);
	}

	private function isLoginResult()
	{
		return app('config')['fcm.log_enabled'];
	}

	private function parseMultipleDevices()
	{
		foreach ($this->response[ 'results' ] as $index => $result) {
			if (array_key_exists('message_id', $result) && (array_key_exists('registration_id', $result) && $this->to[ $index ])) {
				array_add($this->tokenToModify, $this->to[ $index ], $result[ 'registration_id' ]);
			}
			else {
				if (array_key_exists('error', $result) && $this->to[ $index ]) {
					if (in_array('NotRegistered', $result) || in_array('InvalidRegistration', $result)) {
						array_push($this->tokenToDelete, $this->to[ $index ]);
					}
				}
			}
		}
	}

	private function parseUniqueDevice()
	{
		foreach ($this->response[ 'results' ] as $index => $result) {
			if (array_key_exists('message_id', $result) && (array_key_exists('registration_id', $result) && $this->to)) {
				array_add($this->tokenToModify, $this->to, $result[ 'registration_id' ]);
			}
			else {
				if (array_key_exists('error', $result) && $this->to) {
					if (in_array('NotRegistered', $result) || in_array('InvalidRegistration', $result)) {
						array_push($this->tokenToDelete, $this->to);
					}
				}
			}
		}
	}

}
