<?php

namespace LaravelFCM;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class FCMException extends RuntimeException implements HttpExceptionInterface
{
    /**
     * @var int Http status code or exception code
     */
    protected $statusCode;

    /**
     * @var array Http headers
     */
    protected $headers;

    public function __construct($message = null, $statusCode = 400, $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        parent::__construct($message, $statusCode);
    }

    /**
     * Returns the status code.
     *
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}