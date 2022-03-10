<?php

namespace LaravelFCM;

use Illuminate\Support\Str;
use LaravelFCM\Sender\FCMGroup;
use LaravelFCM\Sender\FCMTopic;
use LaravelFCM\Sender\FCMSender;
use Illuminate\Support\ServiceProvider;
use LaravelFCM\Validator\FCMValidator;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NullHandler;

class FCMServiceProvider extends ServiceProvider
{
    /** @var bool */
    protected $defer = true;

    public function boot()
    {
        if (Str::contains($this->app->version(), 'Lumen')) {
            $this->app->configure('fcm');
        } else {
            $this->publishes(
                [
                __DIR__ . '/../config/fcm.php' => config_path('fcm.php'),
                ]
            );
        }
    }

    public function register()
    {
        if (!Str::contains($this->app->version(), 'Lumen')) {
            $this->mergeConfigFrom(__DIR__ . '/../config/fcm.php', 'fcm');
        }

        $this->app->singleton(
            'fcm.client',
            function ($app) {
                return (new FCMManager($app))->driver();
            }
        );

        $this->app->singleton(
            'fcm.logger',
            function ($app) {
                $logger = new Logger('Laravel-FCM');
                if ($app[ 'config' ]->get('fcm.log_enabled', false)) {
                    $logger->pushHandler(new NullHandler());
                } else {
                    $logger->pushHandler(new StreamHandler(storage_path('logs/laravel-fcm.log')));
                }
                return $logger;
            }
        );

        $this->app->bind(
            'fcm.group',
            function ($app) {
                $client = $app[ 'fcm.client' ];
                $url = $app[ 'config' ]->get('fcm.http.server_group_url');
                $logger = $app[ 'fcm.logger' ];

                return new FCMGroup($client, $url, $logger);
            }
        );

        $this->app->bind(
            'fcm.topic',
            function ($app) {
                $client = $app[ 'fcm.client' ];
                $url = $app[ 'config' ]->get('fcm.http.server_topic_url');
                $logger = $app[ 'fcm.logger' ];

                return new FCMTopic($client, $url, $logger);
            }
        );

        $this->app->bind(
            'fcm.sender',
            function ($app) {
                $client = $app[ 'fcm.client' ];
                $url = $app[ 'config' ]->get('fcm.http.server_send_url');
                $logger = $app[ 'fcm.logger' ];

                return new FCMSender($client, $url, $logger);
            }
        );

        $this->app->bind(
            'fcm.validator',
            function ($app) {
                $client = $app[ 'fcm.client' ];
                $url = $app[ 'config' ]->get('fcm.http.server_send_url');
                $logger = $app[ 'fcm.logger' ];


                return new FCMValidator($client, $url, $logger);
            }
        );
    }

    public function provides()
    {
        return ['fcm.client', 'fcm.group', 'fcm.sender', 'fcm.logger', 'fcm.topic' , 'fcm.validator'];
    }
}
