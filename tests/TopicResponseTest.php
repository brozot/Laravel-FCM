<?php

namespace LaravelFCM\Tests;

use GuzzleHttp\Psr7\Response;
use LaravelFCM\Response\TopicResponse;

class TopicsResponseTest extends FCMTestCase
{
    public function testItConstructATopicResponse_with_success()
    {
        $topic = new \LaravelFCM\Message\Topics();
        $topic->topic('topicName');

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $response = new Response(
            200,
            [],
            '{
				"message_id": "1234"
		}'
        );

        $topicResponse = new TopicResponse($response, $topic, $logger);

        $this->assertTrue($topicResponse->isSuccess());
        $this->assertFalse($topicResponse->shouldRetry());
        $this->assertNull($topicResponse->error());
    }

    public function testItConstructATopicResponseWithError()
    {
        $topic = new \LaravelFCM\Message\Topics();
        $topic->topic('topicName');

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $response = new Response(
            200,
            [],
            '{
				"error": "MessageTooBig"
		}'
        );

        $topicResponse = new TopicResponse($response, $topic, $logger);

        $this->assertFalse($topicResponse->isSuccess());
        $this->assertFalse($topicResponse->shouldRetry());
        $this->assertEquals('MessageTooBig', $topicResponse->error());
    }

    public function testItConstructATopicResponseWithErrorAndItShouldRetry()
    {
        $topic = new \LaravelFCM\Message\Topics();
        $topic->topic('topicName');

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $response = new Response(
            200,
            [],
            '{
				"error": "TopicsMessageRateExceeded"
		}'
        );

        $topicResponse = new TopicResponse($response, $topic, $logger);

        $this->assertFalse($topicResponse->isSuccess());
        $this->assertTrue($topicResponse->shouldRetry());
        $this->assertEquals('TopicsMessageRateExceeded', $topicResponse->error());
    }
}
