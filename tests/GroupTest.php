<?php

use LaravelFCM\Downstream\Response as DownstreamResponse;

class GroupResponseTest extends FCMTestCase {

	/**
	 * @test
	 */
	public function it_construct_a_response_with_successes()
	{

		$notificationKey = "notificationKey";

		$response = new \GuzzleHttp\Psr7\Response(200, [], '{
					"success": 2,
					"failure": 0
					}');

		$responseGroup = new DownstreamResponse($response, $notificationKey);

		$this->assertEquals(2, $responseGroup->numberSuccess());
		$this->assertEquals(0, $responseGroup->numberFailure());
		$this->assertCount(0, $responseGroup->tokenToDelete());
		$this->assertCount(0, $responseGroup->failedRegistrationIds());
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_failures()
	{

		$notificationKey = "notificationKey";

		$response = new \GuzzleHttp\Psr7\Response(200, [], '{
					"success": 0,
					"failure": 2,
					"failed_registration_ids":[
					   "regId1",
					   "regId2"
					]}');

		$responseGroup = new DownstreamResponse($response, $notificationKey);

		$this->assertEquals(0, $responseGroup->numberSuccess());
		$this->assertEquals(2, $responseGroup->numberFailure());
		$this->assertCount(0, $responseGroup->tokenToDelete());
		$this->assertCount(2, $responseGroup->failedRegistrationIds());
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_withp_partials_failures()
	{

		$notificationKey = "notificationKey";

		$response = new \GuzzleHttp\Psr7\Response(200, [], '{
					"success": 1,
					"failure": 2,
					"failed_registration_ids":[
					   "regId1",
					   "regId2"
					]}');

		$responseGroup = new DownstreamResponse($response, $notificationKey);

		$this->assertEquals(1, $responseGroup->numberSuccess());
		$this->assertEquals(2, $responseGroup->numberFailure());
		$this->assertCount(0, $responseGroup->tokenToDelete());
		$this->assertCount(2, $responseGroup->failedRegistrationIds());
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_withp_partials_invalid_notification_key()
	{

		$notificationKey = "notificationKey";

		$response = new \GuzzleHttp\Psr7\Response(200, [], '{
			  "multicast_id": 5245459801143083920,
			  "success": 0,
			  "failure": 1,
			  "canonical_ids": 0,
			  "results": [
			    {
			      "error": "InvalidRegistration"
			    }
			  ]
			}');

		$responseGroup = new DownstreamResponse($response, $notificationKey);

		$this->assertEquals(1, $responseGroup->numberFailure());
		$this->assertCount(1, $responseGroup->tokenToDelete());
		$this->assertEquals($notificationKey, $responseGroup->tokenToDelete()[0]);

	}
}