<?php
namespace LaravelFCM\Events;

class UpdateToken
{
	public
		/**@var string**/
		$originalToken,
		/**@var string**/
		$newToken;


    /**
     * Create a new event instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(string $originalToken,string $newToken)
    {
		$this->originalToken=$originalToken;
		$this->newToken=$newToken;
    }
}