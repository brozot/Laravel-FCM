<?php
namespace LaravelFCM\Events;

class UpdateToken
{
	public
		/**
         * Original token to be replaced
         * @var string*
         */
		$originalToken,
		/**
         * New token that should be used
         * @var string*
         */
		$newToken;


    /**
     * UpdateToken constructor.
     * @param string $originalToken Original token (to be replaced with $newToken)
     * @param string $newToken Updated token
     */
    public function __construct(string $originalToken,string $newToken)
    {
		$this->originalToken=$originalToken;
		$this->newToken=$newToken;
    }
}