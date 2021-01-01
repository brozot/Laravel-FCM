<?php

namespace LaravelFCM;

use Illuminate\Support\Str;
use LaravelFCM\Getter\FCMGetter;
use LaravelFCM\Sender\FCMGroup;
use LaravelFCM\Sender\FCMSender;
use Illuminate\Support\ServiceProvider;

class FCMServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        if (Str::contains($this->app->version(), 'Lumen')) {
            $this->app->configure('fcm');
        } else {
            $this->publishes([
                __DIR__.'/../config/fcm.php' => config_path('fcm.php'),
            ]);
        }
    }

    public function register()
    {
		if (!Str::contains($this->app->version(), 'Lumen')) {
            $this->mergeConfigFrom(__DIR__.'/../config/fcm.php', 'fcm');
        }

        $this->app->singleton('fcm.client', function ($app) {
            return (new FCMManager($app))->driver();
        });

        $this->app->bind('fcm.group', function ($app) {
            $client = $app[ 'fcm.client' ];
            $url = $app[ 'config' ]->get('fcm.http.server_group_url');

            return new FCMGroup($client, $url);
        });

        $this->app->bind('fcm.sender', function ($app) {
            $client = $app[ 'fcm.client' ];
            $url = $app[ 'config' ]->get('fcm.http.server_send_url');

            return new FCMSender($client, $url);
        });

        $this->app->bind('fcm.getter', function ($app) {
            $client = $app[ 'fcm.client' ];
            // to avoid a major release , we can check if the config file has this key
            // otherwise , we use the supported key from firebase app instances
            $url = $app[ 'config' ]->get('fcm.http.server_get_app_instance_url')
                ?? 'https://iid.googleapis.com/iid/info';
            return new FCMGetter($client, $url);
        });
    }

    public function provides()
    {
        return ['fcm.client', 'fcm.group', 'fcm.sender'];
    }
}
