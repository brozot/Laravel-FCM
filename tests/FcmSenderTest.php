<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\Topics;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Message\Exceptions\NoTopicProvidedException;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FcmSenderTest extends FCMTestCase
{

    public function testSendToGroupArray()
    {
        $response = new Response(
            200,
            [],
            json_encode([
                "success" => 6,
                "failure" => 3,
                "results" => []
            ])
        );

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

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
