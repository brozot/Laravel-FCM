<?php

namespace LaravelFCM\Tests;

use LaravelFCM\Response\GroupResponse;

class GroupResponseTest extends FCMTestCase
{
    public function testItConstructAResponseWithSuccesses()
    {
        $notificationKey = 'notificationKey';

        $response = new \GuzzleHttp\Psr7\Response(
            200,
            [],
            '{
					"success": 2,
					"failure": 0
					}'
        );

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $responseGroup = new GroupResponse($response, $notificationKey, $logger);

        $this->assertEquals(2, $responseGroup->numberSuccess());
        $this->assertEquals(0, $responseGroup->numberFailure());
        $this->assertCount(0, $responseGroup->tokensFailed());
    }

    public function testItConstructAResponseWithFailures()
    {
        $notificationKey = 'notificationKey';

        $response = new \GuzzleHttp\Psr7\Response(
            200,
            [],
            '{
					"success": 0,
					"failure": 2,
					"failed_registration_ids":[
					   "regId1",
					   "regId2"
					]}'
        );

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $responseGroup = new GroupResponse($response, $notificationKey, $logger);

        $this->assertEquals(0, $responseGroup->numberSuccess());
        $this->assertEquals(2, $responseGroup->numberFailure());
        $this->assertCount(2, $responseGroup->tokensFailed());

        $this->assertEquals('regId1', $responseGroup->tokensFailed()[ 0]);
        $this->assertEquals('regId2', $responseGroup->tokensFailed()[ 1]);
    }

    public function testItConstructAResponseWithPartialsFailures()
    {
        $notificationKey = 'notificationKey';

        $response = new \GuzzleHttp\Psr7\Response(
            200,
            [],
            '{
					"success": 1,
					"failure": 2,
					"failed_registration_ids":[
					   "regId1",
					   "regId2"
					]}'
        );

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $responseGroup = new GroupResponse($response, $notificationKey, $logger);

        $this->assertEquals(1, $responseGroup->numberSuccess());
        $this->assertEquals(2, $responseGroup->numberFailure());
        $this->assertCount(2, $responseGroup->tokensFailed());
    }
}
