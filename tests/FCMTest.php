<?php

class FCMTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function it_load_the_client()
	{
		$prio = new \LaravelFCM\Message\OptionsBuilder();
		$prio->setPriority('toto');
		//$prio->setPriority();

		$this->assertFalse(false);
	}
}