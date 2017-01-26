<?php namespace LaravelFCM\Response\Exceptions;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use LaravelFCM\FCMException;

/**
 * Class ServerResponseException
 *
 * @package LaravelFCM\Response\Exceptions
 */
class ServerResponseException extends FCMException {

	/**
	 * retry after
	 * @var int
	 */
	public $retryAfter;

	/**
	 * ServerResponseException constructor.
	 *
	 * @param GuzzleResponse $response
	 */
	public function __construct(GuzzleResponse $response)
	{
		$code = $response->getStatusCode();
		$responseHeader = $response->getHeaders();
		$responseBody = $response->getBody()->getContents();

		if (array_keys($responseHeader, "Retry-After")) {
			$this->retryAfter = $responseHeader["Retry-After"];
		}

		parent::__construct($responseBody, $code, $responseHeader);
	}
}