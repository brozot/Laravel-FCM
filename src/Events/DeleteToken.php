<?php
namespace LaravelFCM\Events;

class DeleteToken
{
	public
		/**@var string**/
		$tokenToBeDeleted;


    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(string $token)
    {
		$this->tokenToBeDeleted=$token;
    }
}