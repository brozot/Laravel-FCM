<?php

namespace LaravelFCM\Tests;

use LaravelFCM\Response\Exceptions\ServerResponseException;

class ServerResponseExceptionTest extends FCMTestCase
{

    public function testHandleWithoutRetryAfter(): void
    {
        $response = new \GuzzleHttp\Psr7\Response(
            200,
            [],
            ''
        );
        $sre = new ServerResponseException($response);
        $this->assertNull($sre->retryAfter);
    }

    public function testHandleWithRetryAfter(): void
    {
        $response = new \GuzzleHttp\Psr7\Response(
            200,
            [
                // See: https://httpwg.org/specs/rfc7231.html#header.retry-after
                'Retry-After' => 120,
            ],
            ''
        );
        $sre = new ServerResponseException($response);
        $this->assertNotNull($sre->retryAfter);
        $this->assertIsNumeric($sre->retryAfter);
        $this->assertSame(120, $sre->retryAfter);
    }

    public function testHandleWithRetryAfterMultiple(): void
    {
        $response = new \GuzzleHttp\Psr7\Response(
            200,
            [
                // See: https://httpwg.org/specs/rfc7231.html#header.retry-after
                'Retry-After' => [120, 'Fri, 31 Dec 1999 23:59:59 GMT', 420],
            ],
            ''
        );
        $sre = new ServerResponseException($response);
        $this->assertNotNull($sre->retryAfter);
        $this->assertIsNumeric($sre->retryAfter);
        $this->assertSame(120, $sre->retryAfter);
    }
}
