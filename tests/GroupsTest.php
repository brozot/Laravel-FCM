<?php

namespace LaravelFCM\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Sender\FCMGroup;

class GroupsTest extends FCMTestCase
{

    public function testCreateGroup()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'notification_key' => 'notification_keyId',
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $client = new Client(['handler' => $handlerStack]);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMGroup($client, 'http://test.test', $logger);

        $response = $fcm->createGroup('notification_blobblob', ['token1', 'token2']);
        $this->assertSame('notification_keyId', $response);
    }

    public function testAddTokenToGroup()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'notification_key' => 'notification_keyId',
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $client = new Client(['handler' => $handlerStack]);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMGroup($client, 'http://test.test', $logger);

        $response = $fcm->addToGroup('notification_keyName', 'notification_keyId', ['token1']);
        $this->assertSame('notification_keyId', $response);
    }

    public function testRemoveTokenToGroup()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'notification_key' => 'notification_keyId',
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $client = new Client(['handler' => $handlerStack]);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMGroup($client, 'http://test.test', $logger);

        $response = $fcm->removeFromGroup('notificationKeyName', 'notification_keyId', ['token1']);
        $this->assertSame('notification_keyId', $response);
    }
}
