<?php

namespace LaravelFCM\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Sender\FCMSender;

class ResponseTest extends FCMTestCase
{
    public function testItSendANotificationToADevice()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'multicast_id' => 216,
                'success' => 3,
                'failure' => 3,
                'canonical_ids' => 1,
                'results' => [
                    ['message_id' => '1:0408'],
                ],
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $client = new Client(['handler' => $handlerStack]);

        $tokens = 'uniqueToken';

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);
        $this->assertNotNull($fcm->sendTo($tokens));
    }

    public function testItSendANotificationTo_moreThan1000Devices()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'multicast_id' => 216,
                'success' => 3,
                'failure' => 3,
                'canonical_ids' => 1,
                'results' => [
                    ['message_id' => '1:0408'],
                    ['error' => 'Unavailable'],
                    ['error' => 'InvalidRegistration'],
                    ['message_id' => '1:1516'],
                    ['message_id' => '1:2342', 'registration_id' => '32'],
                    ['error' => 'NotRegistered'],
                ],
                ]
            )
        );

        $mock = new MockHandler(
            [
            $response, $response, $response, $response, $response,
            $response, $response, $response, $response, $response,
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $tokens = [];
        for ($i = 0; $i < 10000; ++$i) {
            $tokens[$i] = 'token_' . $i;
        }

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);
        $this->assertNotNull($fcm->sendTo($tokens));
    }

    public function testAnEmptyArrayOfTokensThrownAnException()
    {
        $response = new Response(
            400,
            [],
            json_encode(
                [
                'multicast_id' => 216,
                'success' => 3,
                'failure' => 3,
                'canonical_ids' => 1,
                'results' => [
                    ['message_id' => '1:0408'],
                    ['error' => 'Unavailable'],
                    ['error' => 'InvalidRegistration'],
                    ['message_id' => '1:1516'],
                    ['message_id' => '1:2342', 'registration_id' => '32'],
                    ['error' => 'NotRegistered'],
                ],
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $client = new Client(['handler' => $handlerStack]);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);
        $this->setExceptionExpected(\LaravelFCM\Response\Exceptions\InvalidRequestException::class);
        $fcm->sendTo([]);
    }
}
