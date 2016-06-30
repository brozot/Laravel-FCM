<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Downstream\FCMDownstream;
use LaravelFCM\Downstream\Response as DownstreamResponse;

class ResponseTest extends FCMTestCase {

	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_success()
	{
		$token = "new_token";

		$response = new Response(200, [], "{
		                    \"multicast_id\": 108,
                            \"success\": 1,
                            \"failure\": 0,
                            \"canonical_ids\": 0,
                            \"results\": [
                                { \"message_id\": \"1:08\" }
                            ]
						}" );

		$downstreamResponse = new DownstreamResponse($response, $token);

		$this->assertEquals(1, $downstreamResponse->numberSuccess());
		$this->assertEquals(0, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());

		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(0, $downstreamResponse->tokenToModify());
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_multiple_successes()
	{
		$tokens = [
			"first_token",
		    "second_token",
		    "third_token"
		];

		$response = new Response(200, [], "{
		                    \"multicast_id\": 108,
                            \"success\": 3,
                            \"failure\": 0,
                            \"canonical_ids\": 0,
                            \"results\": [
                                { \"message_id\": \"1:01\" },
                                { \"message_id\": \"1:02\" },
                                { \"message_id\": \"1:03\" }
                            ]
						}" );

		$downstreamResponse = new DownstreamResponse($response, $tokens);

		$this->assertEquals(3, $downstreamResponse->numberSuccess());
		$this->assertEquals(0, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());

		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(0, $downstreamResponse->tokenToModify());
	}


	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_failure()
	{
		$token = "new_token";

		$response = new Response(200, [], "{
		                    \"multicast_id\": 108,
                            \"success\": 0,
                            \"failure\": 1,
                            \"canonical_ids\": 0,
                            \"results\": [
                                 { \"error\": \"NotRegistered\" }
                            ]
						}" );

		$downstreamResponse = new DownstreamResponse($response, $token);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(1, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());
		$this->assertFalse($downstreamResponse->hasMissingRegistrationIds());

		$this->assertCount(1, $downstreamResponse->tokenToDelete());
		$this->assertEquals($token, $downstreamResponse->tokenToDelete()[0]);
		$this->assertCount(0, $downstreamResponse->tokenToModify());
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_multiple_failures()
	{
		$tokens = [
			"first_token",
			"second_token",
			"third_token",
		    "fourth_token"
		];

		$response = new Response(200, [], "{
		                    \"multicast_id\": 108,
                            \"success\": 0,
                            \"failure\": 3,
                            \"canonical_ids\": 0,
                            \"results\": [
                                 { \"error\": \"NotRegistered\" },
                                 { \"error\": \"InvalidRegistration\" },
                                 { \"error\": \"NotRegistered\" },
                                 { \"error\": \"MissingRegistration\"}
                            ]
						}" );

		$downstreamResponse = new DownstreamResponse($response, $tokens);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(3, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());
		$this->assertTrue($downstreamResponse->hasMissingRegistrationIds());


		$this->assertCount(3, $downstreamResponse->tokenToDelete());
		$this->assertEquals($tokens[0], $downstreamResponse->tokenToDelete()[0]);
		$this->assertEquals($tokens[1], $downstreamResponse->tokenToDelete()[1]);
		$this->assertEquals($tokens[2], $downstreamResponse->tokenToDelete()[2]);
		$this->assertCount(0, $downstreamResponse->tokenToModify());
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_token_to_change()
	{
		$token = "new_token";


		$response = new Response(200, [], "{
		                    \"multicast_id\": 108,
                            \"success\": 0,
                            \"failure\": 0,
                            \"canonical_ids\": 1,
                            \"results\": [
                                  { \"message_id\": \"1:2342\", \"registration_id\": \"32\" }
                            ]
						}" );

		$downstreamResponse = new DownstreamResponse($response, $token);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(0, $downstreamResponse->numberFailure());
		$this->assertEquals(1, $downstreamResponse->numberModifiedToken());

		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(1, $downstreamResponse->tokenToModify());

		$this->assertTrue(array_key_exists($token, $downstreamResponse->tokenToModify()));
		$this->assertEquals("32", $downstreamResponse->tokenToModify()[$token]);
	}


	/**
	 * @test
	 */
	public function it_construct_a_response_with_multiple_tokens_to_change()
	{
		$tokens = [
			"first_token",
			"second_token",
			"third_token"
		];

		$response = new Response(200, [], "{
		                    \"multicast_id\": 108,
                            \"success\": 0,
                            \"failure\": 0,
                            \"canonical_ids\": 3,
                            \"results\": [
                                 { \"message_id\": \"1:2342\", \"registration_id\": \"32\" },
                                 { \"message_id\": \"1:2342\", \"registration_id\": \"33\" },
                                 { \"message_id\": \"1:2342\", \"registration_id\": \"34\" }
                            ]
						}" );

		$downstreamResponse = new DownstreamResponse($response, $tokens);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(0, $downstreamResponse->numberFailure());
		$this->assertEquals(3, $downstreamResponse->numberModifiedToken());


		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(3, $downstreamResponse->tokenToModify());

		$this->assertTrue(array_key_exists($tokens[0], $downstreamResponse->tokenToModify()));
		$this->assertEquals("32", $downstreamResponse->tokenToModify()[$tokens[0]]);

		$this->assertTrue(array_key_exists($tokens[1], $downstreamResponse->tokenToModify()));
		$this->assertEquals("33", $downstreamResponse->tokenToModify()[$tokens[1]]);

		$this->assertTrue(array_key_exists($tokens[2], $downstreamResponse->tokenToModify()));
		$this->assertEquals("34", $downstreamResponse->tokenToModify()[$tokens[2]]);
	}


	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_token_unavailable()
	{
		$token = "first_token";

		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 1,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "Unavailable" }
	                      ]
					}' );

		$downstreamResponse = new DownstreamResponse($response, $token);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(1, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());

		// Unavailable is not an error caused by the token validity. it don't need to be deleted$
		$this->assertCount(0, $downstreamResponse->tokenToModify());
		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(1, $downstreamResponse->tokenToRetry()[ DownstreamResponse::UNAVAILABLE ]);

		$this->assertEquals($token, $downstreamResponse->tokenToRetry()[ DownstreamResponse::UNAVAILABLE ][0]);
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_token_server_error()
	{
		$token = "first_token";

		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 1,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "InternalServerError" }
	                      ]
					}' );

		$downstreamResponse = new DownstreamResponse($response, $token);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(1, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());

		// Unavailable is not an error caused by the token validity. it don't need to be deleted$
		$this->assertCount(0, $downstreamResponse->tokenToModify());
		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(1, $downstreamResponse->tokenToRetry()[ DownstreamResponse::INTERNAL_SERVER_ERROR ]);

		$this->assertEquals($token, $downstreamResponse->tokenToRetry()[ DownstreamResponse::INTERNAL_SERVER_ERROR ][0]);
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_token_exceeded()
	{
		$token = "first_token";

		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 1,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "DeviceMessageRateExceeded" }
	                      ]
					}' );

		$downstreamResponse = new DownstreamResponse($response, $token);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(1, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());

		// Unavailable is not an error caused by the token validity. it don't need to be deleted$
		$this->assertCount(0, $downstreamResponse->tokenToModify());
		$this->assertCount(0, $downstreamResponse->tokenToDelete());
		$this->assertCount(1, $downstreamResponse->tokenToRetry()[ DownstreamResponse::DEVICE_MESSAGE_RATE_EXCEEDED ]);

		$this->assertEquals($token, $downstreamResponse->tokenToRetry()[ DownstreamResponse::DEVICE_MESSAGE_RATE_EXCEEDED ][0]);
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_a_mixed_token_to_retry()
	{
		$tokens = [
			"first_token",
			"second_token",
			"third_token",
			"fourth_token",
			"fifth_token",
			"sixth_token"
		];


		$response = new Response(200, [], '{
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 6,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "DeviceMessageRateExceeded" },
							    { "error": "InternalServerError" },
							    { "error": "Unavailable" },
							    { "error": "DeviceMessageRateExceeded" },
							    { "error": "InternalServerError" },
							    { "error": "Unavailable" }
	                      ]
					}' );

		$downstreamResponse = new DownstreamResponse($response, $tokens);

		$this->assertEquals(0, $downstreamResponse->numberSuccess());
		$this->assertEquals(6, $downstreamResponse->numberFailure());
		$this->assertEquals(0, $downstreamResponse->numberModifiedToken());

		// Unavailable is not an error caused by the token validity. it don't need to be deleted$
		$this->assertCount(0, $downstreamResponse->tokenToModify());
		$this->assertCount(0, $downstreamResponse->tokenToDelete());

		$this->assertCount(2, $downstreamResponse->tokenToRetry()[ DownstreamResponse::UNAVAILABLE ]);
		$this->assertCount(2, $downstreamResponse->tokenToRetry()[ DownstreamResponse::INTERNAL_SERVER_ERROR ]);
		$this->assertCount(2, $downstreamResponse->tokenToRetry()[ DownstreamResponse::DEVICE_MESSAGE_RATE_EXCEEDED ]);

		$this->assertEquals($tokens[0], $downstreamResponse->tokenToRetry()[ DownstreamResponse::DEVICE_MESSAGE_RATE_EXCEEDED ][0]);
		$this->assertEquals($tokens[3], $downstreamResponse->tokenToRetry()[ DownstreamResponse::DEVICE_MESSAGE_RATE_EXCEEDED ][1]);
		$this->assertEquals($tokens[1], $downstreamResponse->tokenToRetry()[ DownstreamResponse::INTERNAL_SERVER_ERROR ][0]);
		$this->assertEquals($tokens[4], $downstreamResponse->tokenToRetry()[ DownstreamResponse::INTERNAL_SERVER_ERROR ][1]);
		$this->assertEquals($tokens[2], $downstreamResponse->tokenToRetry()[ DownstreamResponse::UNAVAILABLE ][0]);
		$this->assertEquals($tokens[5], $downstreamResponse->tokenToRetry()[ DownstreamResponse::UNAVAILABLE ][1]);
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_mixed_response()
	{
		$tokens = [
			"first_token",
			"second_token",
			"third_token",
			"fourth_token",
			"fifth_token",
			"sixth_token"
		];

		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 3,
						  "failure": 3,
						  "canonical_ids": 1,
						  "results": [
							    { "message_id": "1:0408" },
							    { "error": "Unavailable" },
							    { "error": "InvalidRegistration" },
							    { "message_id": "1:1516" },
							    { "message_id": "1:2342", "registration_id": "32" },
							    { "error": "NotRegistered"}
	                      ]
					}' );

		$downstreamResponse = new DownstreamResponse($response, $tokens);

		$this->assertEquals(3, $downstreamResponse->numberSuccess());
		$this->assertEquals(3, $downstreamResponse->numberFailure());
		$this->assertEquals(1, $downstreamResponse->numberModifiedToken());
		
		// Unavailable is not an error caused by the token validity. it don't need to be deleted
		$this->assertCount(2, $downstreamResponse->tokenToDelete());
		$this->assertCount(1, $downstreamResponse->tokenToModify());

		$this->assertEquals($tokens[2], $downstreamResponse->tokenToDelete()[0]);
		$this->assertEquals($tokens[5], $downstreamResponse->tokenToDelete()[1]);

		$this->assertTrue(array_key_exists($tokens[4], $downstreamResponse->tokenToModify()));
		$this->assertEquals("32", $downstreamResponse->tokenToModify()[$tokens[4]]);
	}

	/**
	 * @test
	 */
	public function it_construct_a_response_with_multiples_response(){

		$tokens = [
			"first_token",
			"second_token",
			"third_token",
			"fourth_token",
			"fifth_token",
			"sixth_token"
		];

		$tokens1 = [
			"first_1_token",
			"second_1_token",
			"third_1_token",
			"fourth_1_token",
			"fifth_1_token",
			"sixth_1_token"
		];

		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 3,
						  "failure": 3,
						  "canonical_ids": 1,
						  "results": [
							    { "message_id": "1:0408" },
							    { "error": "Unavailable" },
							    { "error": "InvalidRegistration" },
							    { "message_id": "1:1516" },
							    { "message_id": "1:2342", "registration_id": "32" },
							    { "error": "NotRegistered"}
	                      ]
					}' );

		$downstreamResponse = new DownstreamResponse($response, $tokens);
		$downstreamResponse1 = new DownstreamResponse($response, $tokens1);

		$downstreamResponse->merge($downstreamResponse1);

		$this->assertEquals(6, $downstreamResponse->numberSuccess());
		$this->assertEquals(6, $downstreamResponse->numberFailure());
		$this->assertEquals(2, $downstreamResponse->numberModifiedToken());

		// Unavailable is not an error caused by the token validity. it don't need to be deleted
		$this->assertCount(4, $downstreamResponse->tokenToDelete());
		$this->assertCount(2, $downstreamResponse->tokenToModify());

		$this->assertEquals($tokens[2], $downstreamResponse->tokenToDelete()[0]);
		$this->assertEquals($tokens1[2], $downstreamResponse->tokenToDelete()[2]);
		$this->assertEquals($tokens[5], $downstreamResponse->tokenToDelete()[1]);
		$this->assertEquals($tokens1[5], $downstreamResponse->tokenToDelete()[3]);

		$this->assertCount(2, $downstreamResponse->tokenToRetry()[DownstreamResponse::UNAVAILABLE]);
	}

	/**
	 * @test
	 */
	public function it_send_a_notification_to_one_device()
	{
		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 3,
						  "failure": 3,
						  "canonical_ids": 1,
						  "results": [
							    { "message_id": "1:0408" }
	                      ]
					}' );

		$client = Mockery::mock(Client::class);
		$client->shouldReceive('post')->once()->andReturn($response);
		$this->app->singleton('fcm.client', function($app) use($client) {
			return $client;
		});

		$tokens = 'uniqueToken';

		$fcm = new FCMDownstream();
		$fcm->sendTo($tokens);
	}


	/**
	 * @test
	 */
	public function it_send_a_notification_to_more_than_1000_devices()
	{
		$response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 3,
						  "failure": 3,
						  "canonical_ids": 1,
						  "results": [
							    { "message_id": "1:0408" },
							    { "error": "Unavailable" },
							    { "error": "InvalidRegistration" },
							    { "message_id": "1:1516" },
							    { "message_id": "1:2342", "registration_id": "32" },
							    { "error": "NotRegistered"}
	                      ]
					}' );

		$client = Mockery::mock(Client::class);
		$client->shouldReceive('post')->times(10)->andReturn($response);
		$this->app->singleton('fcm.client', function($app) use($client) {
			return $client;
		});

		$tokens = [];
		for ($i=0 ; $i<10000 ; $i++) {
			$tokens[$i] = 'token_'.$i;
		}

		$fcm = new FCMDownstream();
		$fcm->sendTo($tokens);
	}

	/**
	 * @test
	 */
	public function it_send_a_notification_to_a_group_of_devices()
	{
		$response = new Response(200, [], '{ "multicast_id": 108,
							  "success": 1,
							  "failure": 0,
							  "canonical_ids": 0,
							  "results": [
							    { "message_id": "1:08" }
							  ]
							}' );

		$client = Mockery::mock(Client::class);
		$client->shouldReceive('post')->once()->andReturn($response);
		$this->app->singleton('fcm.client', function($app) use($client) {
			return $client;
		});

		$notificationKey = '$notificationKey';

		$fcm = new FCMDownstream();
		$fcm->sendTo($notificationKey);
	}
}