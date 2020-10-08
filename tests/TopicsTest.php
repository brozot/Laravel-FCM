<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Message\Topics;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Message\Exceptions\NoTopicProvidedException;

class TopicsTest extends FCMTestCase
{
    public function testItThrowAnExceptionIfNoTopicIsProvided()
    {
        $topics = new Topics();

        $this->setExceptionExpected(NoTopicProvidedException::class);
        $topics->build();
    }

    public function testItHasOnlyOneTopic()
    {
        $target = '/topics/myTopic';

        $topics = new Topics();

        $topics->topic('myTopic');

        $this->assertEquals($target, $topics->build());
    }

    public function testItHasTwoTopicsAnd()
    {
        $target = [
            'condition' => "'firstTopic' in topics && 'secondTopic' in topics",
        ];

        $topics = new Topics();

        $topics->topic('firstTopic')->andTopic('secondTopic');

        $this->assertEquals($target, $topics->build());
    }

    public function testItHasTwoTopicsOr()
    {
        $target = [
            'condition' => "'firstTopic' in topics || 'secondTopic' in topics",
        ];

        $topics = new Topics();

        $topics->topic('firstTopic')->orTopic('secondTopic');

        $this->assertEquals($target, $topics->build());
    }

    public function testItHasTwoTopicsOrAndOneAnd()
    {
        $target = [
            'condition' => "'firstTopic' in topics || 'secondTopic' in topics && 'thirdTopic' in topics",
        ];

        $topics = new Topics();

        $topics->topic('firstTopic')->orTopic('secondTopic')->andTopic('thirdTopic');

        $this->assertEquals($target, $topics->build());
    }

    public function testItHasAComplexTopicCondition()
    {
        $target = [
            'condition' => "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics) || ('TopicD' in topics && 'TopicE' in topics)",
        ];

        $topics = new Topics();

        $topics->topic('TopicA')
               ->andTopic(function ($condition) {
                   $condition->topic('TopicB')->orTopic('TopicC');
               })
               ->orTopic(function ($condition) {
                   $condition->topic('TopicD')->andTopic('TopicE');
               });

        $this->assertEquals($target, $topics->build());
    }

    public function testItSendsANotificationToATopic()
    {
        $response = new Response(200, [], '{"message_id":6177433633397011933}');

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);

        $topics = new Topics();
        $topics->topic('test');

        $response = $fcm->sendToTopic($topics);

        $this->assertTrue($response->isSuccess());
        $this->assertFalse($response->shouldRetry());
        $this->assertNull($response->error());
    }

    public function testItSendsANotificationToATopicAndReturnError()
    {
        $response = new Response(200, [], '{"error":"TopicsMessageRateExceeded"}');

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);

        $topics = new Topics();
        $topics->topic('test');

        $response = $fcm->sendToTopic($topics);

        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->shouldRetry());
        $this->assertEquals('TopicsMessageRateExceeded', $response->error());
    }
}
