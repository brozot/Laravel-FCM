<?php
namespace LaravelFCM\Events;

class Resend
{
	public
		/**@var string**/
		$token;


    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(string $token)
    {
		$this->token=$token;
    }
}