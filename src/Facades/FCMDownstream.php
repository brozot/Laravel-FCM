<?php namespace LaravelFCM\Facades;

use LaravelFCM\Message;
use Illuminate\Support\Facades\Facade;

class FCMDownstream extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'fcm.downstream';
	}
}