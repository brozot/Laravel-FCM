<?php

namespace LaravelFCM\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Message\Exceptions\InvalidOptionsException;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\OptionsPriorities;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Sender\FCMSender;

class PayloadTest extends FCMTestCase
{
    public function testItConstructAValidJsonWithOption()
    {
        $targetPartial = '{
					"collapse_key":"collapseKey",
					"content_available":true
				}';

        $targetFull = '{
					"collapse_key":"collapseKey",
					"content_available":true,
					"priority":"high",
					"delay_while_idle":true,
					"time_to_live":200,
					"restricted_package_name":"customPackageName",
					"dry_run": true
				}';

        $optionBuilder = new OptionsBuilder();

        $optionBuilder->setCollapseKey('collapseKey');
        $optionBuilder->setContentAvailable(true);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetPartial, $json);

        $optionBuilder->setPriority(OptionsPriorities::high)
            ->setDelayWhileIdle(true)
            ->setDryRun(true)
            ->setRestrictedPackageName('customPackageName')
            ->setTimeToLive(200);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetFull, $json);
    }

    public function testBuildOptionsDirectBootOk()
    {
        $targetPartial = '{
					"direct_boot_ok": true,
					"content_available":true
				}';

        $targetFull = '{
					"collapse_key":"collapseKey",
					"content_available":true,
					"priority":"high",
					"delay_while_idle":true,
					"time_to_live":200,
					"restricted_package_name":"customPackageName",
					"dry_run": true,
					"direct_boot_ok": true
				}';

        $optionBuilder = new OptionsBuilder();

        $optionBuilder->setDirectBootOk(true);
        $optionBuilder->setContentAvailable(true);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetPartial, $json);

        $optionBuilder->setPriority(OptionsPriorities::high)
            ->setCollapseKey('collapseKey')
            ->setDelayWhileIdle(true)
            ->setDryRun(true)
            ->setRestrictedPackageName('customPackageName')
            ->setTimeToLive(200);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetFull, $json);
    }

    public function testBuildOptionsFcmOptionsAnalyticsLabel()
    {
        $targetPartial = '{
					"direct_boot_ok": true,
					"content_available":true
				}';

        $targetFull = '{
					"collapse_key":"collapseKey",
					"content_available":true,
					"priority":"high",
					"delay_while_idle":true,
					"time_to_live":200,
					"fcm_options": {
            "analytics_label": "UA-xxxxxxx"
          },
					"dry_run": true,
					"direct_boot_ok": true
				}';

        $optionBuilder = new OptionsBuilder();

        $optionBuilder->setDirectBootOk(true);
        $optionBuilder->setContentAvailable(true);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetPartial, $json);
        $this->assertNull($optionBuilder->getFcmOptionsAnalyticsLabel());
        $optionBuilder->setPriority(OptionsPriorities::high)
            ->setCollapseKey('collapseKey')
            ->setDelayWhileIdle(true)
            ->setDryRun(true)
            ->setFcmOptionsAnalyticsLabel('UA-xxxxxxx')
            ->setTimeToLive(200);

        $this->assertSame('UA-xxxxxxx', $optionBuilder->getFcmOptionsAnalyticsLabel());
        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetFull, $json);
    }

    public function testFullWithAnalytics()
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
        $container = [];
        $history = Middleware::history($container);
        $handlerStack->push($history);
        $client = new Client(['handler' => $handlerStack]);

        $tokens = 'uniqueToken';

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\NullHandler());

        $fcm = new FCMSender($client, 'http://test.test', $logger);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setDirectBootOk(true);
        $optionBuilder->setContentAvailable(true);
        $optionBuilder->setPriority(OptionsPriorities::high)
            ->setCollapseKey('collapseKey')
            ->setDelayWhileIdle(true)
            ->setDryRun(true)
            ->setFcmOptionsAnalyticsLabel('UA-xxxxxxx')
            ->setTimeToLive(200);

        $dataBuilder = new PayloadDataBuilder();
        $payloadData = ['foo' => 'bar'];
        $dataBuilder->addData($payloadData);
        $data = $dataBuilder->build();// You must change it to get your tokens

        $this->assertNotNull($fcm->sendTo($tokens, $optionBuilder->build(), null, $data));

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $container[0]['request'];
        $this->assertSame(
            [
              'to' => 'uniqueToken',
              'data' => [
                'foo' => 'bar',
              ],
              'collapse_key' => 'collapseKey',
              'priority' => 'high',
              'content_available' => true,
              'delay_while_idle' => true,
              'time_to_live' => 200,
              'dry_run' => true,
              'direct_boot_ok' => true,
              'fcm_options' => [
                'analytics_label' => 'UA-xxxxxxx',
              ],
            ],
            json_decode($request->getBody()->__toString(), true)
        );
    }

    public function testItConstructAValidJsonWithData()
    {
        $targetAdd = '{
				"first_data":"first",
				"second_data":true
			}';

        $targetSet = '
				{
					"third_data":"third",
					"fourth_data":4
				}';

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder->addData(['first_data' => 'first'])
            ->addData(['second_data' => true]);

        $json = json_encode($dataBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetAdd, $json);

        $dataBuilder->setData(['third_data' => 'third', 'fourth_data' => 4]);

        $json = json_encode($dataBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetSet, $json);
    }

    public function testItConstructAValidJsonWithNotification()
    {
        $targetPartial = '{
					"title":"test_title",
					"body":"test_body",
					"badge":"test_badge",
					"sound":"test_sound",
					"image":"test_image"
				}';

        $targetFull = '{
					"title":"test_title",
					"body":"test_body",
					"android_channel_id":"test_channel_id",
					"badge":"test_badge",
					"sound":"test_sound",
					"tag":"test_tag",
					"color":"test_color",
					"click_action":"test_click_action",
					"body_loc_key":"test_body_key",
					"body_loc_args":"[ body0, body1 ]",
					"title_loc_key":"test_title_key",
					"title_loc_args":"[ title0, title1 ]",
					"icon":"test_icon",
					"image":"test_image"
				}';

        $notificationBuilder = new PayloadNotificationBuilder();

        $notificationBuilder->setTitle('test_title')
                    ->setBody('test_body')
                    ->setSound('test_sound')
                    ->setBadge('test_badge')
                    ->setImage('test_image');

        $json = json_encode($notificationBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetPartial, $json);

        $notificationBuilder
                    ->setChannelId('test_channel_id')
                    ->setTag('test_tag')
                    ->setColor('test_color')
                    ->setClickAction('test_click_action')
                    ->setBodyLocationKey('test_body_key')
                    ->setBodyLocationArgs('[ body0, body1 ]')
                    ->setTitleLocationKey('test_title_key')
                    ->setTitleLocationArgs('[ title0, title1 ]')
                    ->setIcon('test_icon')
                    ->setImage('test_image');

        $json = json_encode($notificationBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetFull, $json);
    }

    public function testItThrowsAnInvalidOptionsExceptionIfTheIntervalIsTooBig()
    {
        $this->setExceptionExpected(InvalidOptionsException::class);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(2419200 * 10);
    }
}
