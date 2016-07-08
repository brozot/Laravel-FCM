<?php namespace LaravelFCM\Sender;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class Response
 *
 * @package LaravelFCM\Sender
 */
class Response {

	const SUCCESS = 'success';
	const FAILURE = 'failure';
	const CANONICAL_IDS = "canonical_ids";
	const RESULTS = "results";
	const ERROR = "error";

	const MISSING_REGISTRATION = "MissingRegistration";
	const INVALID_PACKAGE_NAME = "InvalidPackageName";
	const MISMATCH_SENDER_ID = "MismatchSenderId";
	const MESSAGE_TOO_BIG = "MessageTooBig";
	const INVALID_DATA_KEY = "InvalidDataKey";
	const INVALID_TTL = "InvalidTtl";
	const MESSAGE_ID = "message_id";
	const REGISTRATION_ID = "registration_id";
	const NOT_REGISTERED = "NotRegistered";
	const INVALID_REGISTRATION = "InvalidRegistration";
	const UNAVAILABLE = "Unavailable";
	const INTERNAL_SERVER_ERROR = "InternalServerError";
	const DEVICE_MESSAGE_RATE_EXCEEDED = "DeviceMessageRateExceeded";
	const FAILED_REGISTRATION_IDS = "failed_registration_ids";
	const TOPIC_MESSAGE_RATE_EXCEEDED = "TopicsMessageRateExceeded";

	/**
	 * @internal
	 * @var int
	 */
	protected $numberSuccess = 0;

	/**
	 * @internal
	 * @var int
	 */
	protected $numberFailure = 0;

	/**
	 * @internal
	 * @var int
	 */
	protected $numberCanonicalId = 0;

	/**
	 * @internal
	 * @var bool
	 */
	protected $hasMissingRegistrationIds = false;

	/**
	 * @internal
	 * @var array
	 */
	protected $tokensToDelete = [];

	/**
	 * @internal
	 * @var array
	 */
	protected $tokensToModify = [];

	/**
	 * @internal
	 * @var array
	 */
	protected $failedRegistrationIds = [];

	/**
	 * @internal
	 * @var array
	 */
	protected $tokensToRetry = [
		self::UNAVAILABLE                  => [],
		self::INTERNAL_SERVER_ERROR        => [],
		self::DEVICE_MESSAGE_RATE_EXCEEDED => []
	];

	/**
	 * @internal
	 * @var
	 */
	protected $to;

	/**
	 * @internal
	 * @var mixed
	 */
	protected $response;

	/**
	 * Response constructor.
	 *
	 * @param GuzzleResponse $response
	 * @param array|string|null $to
	 * @throws InvalidPackageException
	 * @throws InvalidNotificationException
	 * @throws MessageToBigException
	 * @throws InvalidDataKeyException
	 * @throws InvalidTTLException
	 * @throws TopicsMessageRateExceededException
	 */
	public function __construct(GuzzleResponse $response, $to)
	{

		if ($response->getStatusCode() != 200) {

			throw new InvalidNotificationException($response->getBody()->getContents());
		}

		$this->to = $to;
		$this->response = json_decode($response->getBody(), true);

		$this->detectCommonErrors();
		$this->parse();

		if ($this->isLoginResult()) {
			$this->logResults();
		}
	}

	/**
	 * @internal
	 * @throws TopicsMessageRateExceededException
	 */
	private function parse()
	{
		if (!array_key_exists(self::SUCCESS, $this->response) && !array_key_exists(self::FAILURE, $this->response) && !array_key_exists(self::CANONICAL_IDS, $this->response) && !array_key_exists(self::FAILED_REGISTRATION_IDS, $this->response)) {
			$this->parseTopic();
			return;
		}

		if (array_key_exists(self::SUCCESS, $this->response)) {
			$this->numberSuccess = $this->response[ self::SUCCESS ];
		}

		if (array_key_exists(self::FAILURE, $this->response)) {
			$this->numberFailure = $this->response[ self::FAILURE ];
		}

		if (array_key_exists(self::CANONICAL_IDS, $this->response)) {
			$this->numberCanonicalId = $this->response[ self::CANONICAL_IDS ];
		}

		if (array_key_exists(self::FAILED_REGISTRATION_IDS, $this->response)) {
			$this->failedRegistrationIds = $this->response[ self::FAILED_REGISTRATION_IDS ];
		}

		if ($this->numberFailure != 0 || $this->numberCanonicalId != 0) {
			$this->parseResult();
		}
	}

	/**
	 * @internal
	 */
	private function parseResult()
	{
		if (is_array($this->to)) {
			$this->parseMultipleDevices();
		}
		else {
			$this->parseUniqueDevice();
		}
	}

	/**
	 * get the number of token where the message was sent with success
	 * @return int
	 */
	public function numberSuccess()
	{
		return $this->numberSuccess;
	}

	/**
	 * get the number of token where the  message was not be sent
	 * @return int
	 */
	public function numberFailure()
	{
		return $this->numberFailure;
	}

	/**
	 * get the number of token where the notification was sent but that need to be changed
	 * @return int
	 */
	public function numberModifiedToken()
	{
		return $this->numberCanonicalId;
	}

	/**
	 * If true, you should check if you database contains some empty tokens and remove they
	 *
	 * @internal
	 * @return bool
	 */
	public function hasMissingRegistrationIds()
	{
		return $this->hasMissingRegistrationIds;
	}

	/**
	 * Get a list of token which must be deleted from the database
	 *
	 * @return array
	 */
	public function tokenToDelete()
	{
		return $this->tokensToDelete;
	}

	/**
	 * Get a list of token that must be modified in the database
	 *
	 * key: oldToken
	 * value: new token
	 *
	 * @return array
	 */
	public function tokenToModify()
	{
		return $this->tokensToModify;
	}

	/**
	 * Get a list of token that you should retry to send a message
	 *
	 * key: oldToken
	 * value: new token
	 *
	 * @return array
	 */
	public function tokenToRetry()
	{
		return $this->tokensToRetry;
	}

	/**
	 * For group get the list of tokens where the notification was sent but that need to be changed
	 *
	 * @return array
	 */
	public function failedRegistrationIds()
	{
		return $this->failedRegistrationIds;
	}

	/**
	 * Merge two response
	 *
	 * @param Response $response
	 */
	public function merge(Response $response)
	{
		$this->numberSuccess += $response->numberSuccess();
		$this->numberFailure += $response->numberFailure();
		$this->numberCanonicalId += $response->numberModifiedToken();


		$this->tokensToDelete = array_merge($this->tokensToDelete, $response->tokenToDelete());
		$this->tokensToModify = array_merge($this->tokensToModify, $response->tokenToModify());
		$this->failedRegistrationIds = array_merge($this->failedRegistrationIds, $response->failedRegistrationIds());
		
		$this->tokensToRetry[ self::UNAVAILABLE ] = array_merge($this->tokensToRetry[ self::UNAVAILABLE ], $this->tokenToRetry()[ self::UNAVAILABLE ]);
		$this->tokensToRetry[ self::INTERNAL_SERVER_ERROR ] = array_merge($this->tokensToRetry[ self::INTERNAL_SERVER_ERROR ], $this->tokenToRetry()[ self::INTERNAL_SERVER_ERROR ]);
		$this->tokensToRetry[ self::DEVICE_MESSAGE_RATE_EXCEEDED ] = array_merge($this->tokensToRetry[ self::DEVICE_MESSAGE_RATE_EXCEEDED ], $this->tokenToRetry()[ self::DEVICE_MESSAGE_RATE_EXCEEDED ]);
	}

	/**
	 * @internal
	 *
	 * @throws InvalidDataKeyException
	 * @throws InvalidPackageException
	 * @throws InvalidTTLException
	 * @throws MessageToBigException
	 */
	private function detectCommonErrors() {

		if (!array_key_exists(self::RESULTS, $this->response)) {
			return;
		}

		foreach ($this->response[ self::RESULTS ] as $result) {
			if (array_key_exists(self::ERROR, $result)) {

				if (in_array(self::MISSING_REGISTRATION, $result)) {
					$this->hasMissingRegistrationIds = true;
				}

				if (in_array(self::INVALID_PACKAGE_NAME, $result)) {
					throw new InvalidPackageException();
				}

				if (in_array(self::MISMATCH_SENDER_ID, $result)) {
					throw new InvalidPackageException();
				}

				if (in_array(self::MESSAGE_TOO_BIG, $result)) {
					throw new MessageToBigException();
				}

				if (in_array(self::INVALID_DATA_KEY, $result)) {
					throw new InvalidDataKeyException();
				}

				if (in_array(self::INVALID_TTL, $result)) {
					throw new InvalidTTLException();
				}
			}
		}
	}

	/**
	 * @internal
	 */
	private function parseMultipleDevices()
	{
		if (!array_key_exists(self::RESULTS, $this->response)) {
			return;
		}

		foreach ($this->response[ self::RESULTS ] as $index => $result) {
			if (array_key_exists(self::MESSAGE_ID, $result) && (array_key_exists(self::REGISTRATION_ID, $result) && $this->to[ $index ])) {
				$this->tokensToModify[ $this->to[ $index ] ] = $result[ self::REGISTRATION_ID ];
			}
			else {
				if (array_key_exists(self::ERROR, $result) && $this->to[ $index ]) {
					if (in_array(self::NOT_REGISTERED, $result) || in_array(self::INVALID_REGISTRATION, $result)) {
						array_push($this->tokensToDelete, $this->to[ $index ]);
					}

					if (in_array(self::UNAVAILABLE, $result)) {
						array_push($this->tokensToRetry[ self::UNAVAILABLE ], $this->to[ $index ]);
					}

					if (in_array(self::INTERNAL_SERVER_ERROR, $result)) {
						array_push($this->tokensToRetry[ self::INTERNAL_SERVER_ERROR ], $this->to[ $index ]);
					}

					if (in_array(self::DEVICE_MESSAGE_RATE_EXCEEDED, $result)) {
						array_push($this->tokensToRetry[ self::DEVICE_MESSAGE_RATE_EXCEEDED ], $this->to[ $index ]);
					}
				}
			}
		}
	}

	/**
	 * @internal
	 */
	private function parseUniqueDevice()
	{
		if (!array_key_exists(self::RESULTS, $this->response)) {
			return;
		}

		foreach ($this->response[ self::RESULTS ] as $index => $result) {
			if (array_key_exists(self::MESSAGE_ID, $result) && (array_key_exists(self::REGISTRATION_ID, $result) && $this->to)) {
				$this->tokensToModify[ $this->to] = $result[ self::REGISTRATION_ID ];
			}
			else {
				if (array_key_exists(self::ERROR, $result) && $this->to) {
					if (in_array(self::NOT_REGISTERED, $result) || in_array(self::INVALID_REGISTRATION, $result)) {
						array_push($this->tokensToDelete, $this->to);
					}
				}

				if (in_array(self::UNAVAILABLE, $result)) {
					array_push($this->tokensToRetry[ self::UNAVAILABLE ], $this->to);
				}

				if (in_array(self::INTERNAL_SERVER_ERROR, $result)) {
					array_push($this->tokensToRetry[ self::INTERNAL_SERVER_ERROR ],  $this->to);
				}

				if (in_array(self::DEVICE_MESSAGE_RATE_EXCEEDED, $result)) {
					array_push($this->tokensToRetry[ self::DEVICE_MESSAGE_RATE_EXCEEDED ],  $this->to);
				}
			}
		}
	}

	/**
	 * @internal
	 */
	private function logResults()
	{
		$logger = new Logger('Laravel-FCM');
		$logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));

		$logMessage =  "notification send to ".count($this->to)." devices".PHP_EOL;
		$logMessage .= "success: ".$this->numberSuccess.PHP_EOL;
		$logMessage .= "failures: ".$this->numberFailure.PHP_EOL;
		$logMessage .= "number of modified token : ".$this->numberCanonicalId.PHP_EOL;
		$logMessage .= "canonical_ids : ".implode("|", $this->tokensToModify).PHP_EOL;

		$logger->info($logMessage);
	}

	/**
	 * @internal
	 *
	 * @return mixed
	 */
	private function isLoginResult()
	{
		return app('config')['fcm.log_enabled'];
	}

	/**
	 * @internal
	 *
	 * @throws TopicsMessageRateExceededException
	 */
	private function parseTopic()
	{
		if (key_exists('message_id', $this->response)) {
			$this->numberSuccess = 1;
		}
		else if (in_array(self::TOPIC_MESSAGE_RATE_EXCEEDED, $this->response)) {
			$this->numberFailure = 1;
			throw new TopicsMessageRateExceededException('To many message was send please wait util retry');
		}
		else {
			$this->numberFailure = 1;
		}
	}
}

/**
 * Class InvalidPackageException
 *
 * @package LaravelFCM\Sender
 */
class InvalidPackageException extends Exception {}

/**
 * Class InvalidNotificationException
 *
 * @package LaravelFCM\Sender
 */
class InvalidNotificationException extends Exception {}

/**
 * Class InvalidSenderIdException
 *
 * @package LaravelFCM\Sender
 */
class InvalidSenderIdException extends Exception {}

/**
 * Class MessageToBigException
 *
 * @package LaravelFCM\Sender
 */
class MessageToBigException extends Exception {}

/**
 * Class InvalidDataKeyException
 *
 * @package LaravelFCM\Sender
 */
class InvalidDataKeyException extends Exception {}

/**
 * Class InvalidTTLException
 *
 * @package LaravelFCM\Sender
 */
class InvalidTTLException extends Exception {}

/**
 * Class TopicsMessageRateExceededException
 *
 * @package LaravelFCM\Sender
 */
class TopicsMessageRateExceededException extends Exception {}
