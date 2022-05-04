<?php

namespace LaravelFCM\Response\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ServerResponseException extends Exception
{
    /**
     * The value of the first Retry-After header in the response.
     *
     * @see https://httpwg.org/specs/rfc7231.html#header.retry-after
     * @var int|string
     */
    public $retryAfter;

    /**
     * ServerResponseException constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $responseHeader = $response->getHeaders();
        $responseBody = $response->getBody()->getContents();

        if (array_key_exists('Retry-After', $responseHeader)) {
            $retryAfterValue = $responseHeader['Retry-After'][0];
            $this->retryAfter = is_numeric($retryAfterValue) ? (int) $retryAfterValue : $retryAfterValue;
        }

        parent::__construct($responseBody, $code);
    }
}
