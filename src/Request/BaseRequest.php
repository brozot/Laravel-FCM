<?php

namespace LaravelFCM\Request;

/**
 * Class BaseRequest.
 */
abstract class BaseRequest
{
    /**
     * BaseRequest constructor.
     */
    public function __construct()
    {
    }

    /**
     * Build the body of the request.
     *
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build()
    {
        return [
            'json' => $this->buildBody(),
        ];
    }
}
