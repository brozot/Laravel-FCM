<?php
namespace LaravelFCM\Events;

class WithErrors
{
	public
		/**
         * Token that generated the errors
         * @var string
         **/
		$token,
        /**
         * Errors
         * @var mixed
         */
		$errors;


    /**
     * WithErrors constructor.
     * @param string $token Token with errors
     * @param mixed $errors Errors encountered
     */
    public function __construct(string $token,$errors)
    {
		$this->token	= $token;
		$this->errors 	= $errors;
    }
}