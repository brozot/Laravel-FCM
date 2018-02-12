<?php
namespace LaravelFCM\Events;

class Resend
{
	public
		/**@var string**/
		$token;

    /**
     * Resend constructor.
     * @param string $token Token that should be resended
     */
    public function __construct(string $token)
    {
		$this->token=$token;
    }
}