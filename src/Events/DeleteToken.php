<?php
namespace LaravelFCM\Events;

class DeleteToken
{
	public
		/**
         * Token that should be deleted
         * @var string*
         */
		$tokenToBeDeleted;


    /**
     * DeleteToken constructor.
     * @param string $token Token to be deleted
     */
    public function __construct(string $token)
    {
		$this->tokenToBeDeleted=$token;
    }
}