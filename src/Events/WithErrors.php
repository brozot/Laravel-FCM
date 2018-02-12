<?php
namespace LaravelFCM\Events;

class WithErrors
{
	public
		/**@var string**/
		$token,
		$errors;


    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(string $token,$errors)
    {
		$this->token	= $token;
		$this->errors 	= $errors;
    }
}