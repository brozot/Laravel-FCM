<?php

namespace LaravelFCM\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FcmSenderTest extends FCMTestCase
{

    public function testSendToGroupArray()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'success' => 6,
                'failure' => 3,
                'results' => [],
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $container = [];
        $history = Middleware::history($container);
        $handlerStack->push($history);
        $client = new Client(['handler' => $handlerStack]);

        $notificationKey = ['a_notification_key'];

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $notification = $notificationBuilder->build();

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);
        $groupResponse = $fcm->sendToGroup($notificationKey, null, $notification, null);

        $this->assertSame(6, $groupResponse->numberSuccess());
        $this->assertSame(3, $groupResponse->numberFailure());
        $this->assertSame([], $groupResponse->tokensFailed());
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $container[0]['request'];
        $this->assertSame(
            json_encode(
                [
                'registration_ids' => ['a_notification_key'],
                'notification' => ['title' => 'my title', 'body' => 'Hello world', 'sound' => 'default'],
                ]
            ),
            $request->getBody()->__toString()
        );
    }

    public function testSendToGroupArrayTwoKeys()
    {
        $response = new Response(
            200,
            [],
            json_encode(
                [
                'success' => 6,
                'failure' => 3,
                'results' => [],
                ]
            )
        );

        $handlerStack = HandlerStack::create(new MockHandler([$response]));
        $container = [];
        $history = Middleware::history($container);
        $handlerStack->push($history);
        $client = new Client(['handler' => $handlerStack]);

        $notificationKey = ['a_notification_key', 'b_notification_key'];

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $notification = $notificationBuilder->build();

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);
        $groupResponse = $fcm->sendToGroup($notificationKey, null, $notification, null);

        $this->assertSame(6, $groupResponse->numberSuccess());
        $this->assertSame(3, $groupResponse->numberFailure());
        $this->assertSame([], $groupResponse->tokensFailed());

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $container[0]['request'];
        $this->assertSame(
            json_encode(
                [
                'registration_ids' => ['a_notification_key', 'b_notification_key'],
                'notification' => ['title' => 'my title', 'body' => 'Hello world', 'sound' => 'default'],
                ]
            ),
            $request->getBody()->__toString()
        );
    }
}
