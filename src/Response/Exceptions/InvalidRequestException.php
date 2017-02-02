<?php

namespace LaravelFCM\Response\Exceptions;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use LaravelFCM\FCMException;

/**
 * Class InvalidRequestException.
 */
class InvalidRequestException extends Exception
{
    /**
     * InvalidRequestException constructor.
     *
     * @param GuzzleResponse $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $code = $response->getStatusCode();
        $responseBody = $response->getBody()->getContents();

        parent::__construct($responseBody, $code);
    }
}
