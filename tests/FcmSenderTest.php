<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FcmSenderTest extends FCMTestCase
{

    public function testSendToGroupArray()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                "success" => 6,
                "failure" => 3,
                "results" => []
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
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
    }
}
