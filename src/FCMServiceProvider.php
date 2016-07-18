<?php namespace LaravelFCM;

use LaravelFCM\Sender\FCMGroup;
use LaravelFCM\Sender\FCMSender;
use Illuminate\Support\ServiceProvider;

class FCMServiceProvider extends ServiceProvider {

	protected $defer = true;

	public function boot()
	{
		if (str_contains($this->app->version(), 'Lumen')) {
			$this->app->configure('fcm');
		}
		else {
			$this->publishes([
				__DIR__."/../config/fcm.php" => config_path('fcm.php')
			]);
		}
	}

	public function register()
	{
		$this->app->bind('fcm.group', function($app) {
			return new FCMGroup();
		});

		$this->app->bind('fcm.sender', function($app) {
			return new FCMSender();
		});
		
		$this->registerClient();
	}

	public function registerClient()
	{
		$this->app->singleton('fcm.client', function($app) {
			return (new FCMManager($app))->driver();
		});
	}

	protected function provide()
	{
		return [ 'fcm.group', 'fcm.sender', 'fcm.client' ];
	}
}