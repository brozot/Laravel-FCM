<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Message\Topics;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Sender\Response as DownstreamResponse;

class TopicsTest extends FCMTestCase {

	/**
	 * @test
	 */
	public function it_throw_an_exception_if_no_topic_is_provided()
	{
		$topics = new Topics();

		$this->setExpectedException(\LaravelFCM\Message\NoTopicProvided::class);
		$topics->build();

	}

	/**
	 * @test
	 */
	public function it_has_only_one_topic()
	{
		$target = "/topics/myTopic";

		$topics = new Topics();

		$topics->topic('myTopic');

		$this->assertEquals($target, $topics->build());

	}

	/**
	 * @test
	 */
	public function it_has_two_topics_and()
	{
		$target = [
			'condition' => "'firstTopic' in topics && 'secondTopic' in topics"
		];

		$topics = new Topics();

		$topics->topic('firstTopic')->andTopic('secondTopic');

		$this->assertEquals($target, $topics->build());
	}

	/**
	 * @test
	 */
	public function it_has_two_topics_or()
	{
		$target = [
			'condition' => "'firstTopic' in topics || 'secondTopic' in topics"
		];

		$topics = new Topics();

		$topics->topic('firstTopic')->orTopic('secondTopic');

		$this->assertEquals($target, $topics->build());
	}

	/**
	 * @test
	 */
	public function it_has_two_topics_or_and_one_and()
	{
		$target = [
			'condition' => "'firstTopic' in topics || 'secondTopic' in topics && 'thirdTopic' in topics"
		];

		$topics = new Topics();

		$topics->topic('firstTopic')->orTopic('secondTopic')->andTopic('thirdTopic');

		$this->assertEquals($target, $topics->build());
	}

	/**
	 * @test
	 */
	public function it_has_a_complex_topic_condition()
	{
		$target = [
			'condition' =>  "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics) || ('TopicD' in topics && 'TopicE' in topics)"
		];

		$topics = new Topics();

		$topics->topic('TopicA')
		       ->andTopic(function($condition) {
			       $condition->topic('TopicB')->orTopic('TopicC');
		       })
			   ->orTopic(function($condition) {
				   $condition->topic('TopicD')->andTopic('TopicE');
			   });


		$this->assertEquals($target, $topics->build());
	}

	/**
	 * @test
	 */
	public function it_send_a_notification_to_a_group_of_devices()
	{
		$response = new Response(200, [], '{"message_id":6177433633397011933}' );

		$client = Mockery::mock(Client::class);
		$client->shouldReceive('post')->once()->andReturn($response);
		$this->app->singleton('fcm.client', function($app) use($client) {
			return $client;
		});


		$fcm = new FCMSender();

		$topics = new Topics();
		$topics->topic('test');

		$response = $fcm->sendToTopic($topics);
		
		$this->assertEquals(1, $response->numberSuccess());
		$this->assertEquals(0, $response->numberFailure());
	}
}