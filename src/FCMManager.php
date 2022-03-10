<?php

namespace LaravelFCM;

use GuzzleHttp\Client;
use Illuminate\Support\Manager;

class FCMManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->getContainer()[ 'config' ][ 'fcm.driver' ];
    }

    /**
     * @return Client
     */
    protected function createHttpDriver()
    {
        $config = $this->getContainer()[ 'config' ]->get('fcm.http', []);

        return new Client(['timeout' => $config[ 'timeout' ]]);
    }

    /**
     * Get the app container
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        // @phpstan-ignore-next-line
        if (isset($this->container)) {// Laravel 7.x, 8.x support
            return $this->container;
        }
        // "app" Does not exist anymore in 8.x
        return $this->app;// @phpstan-ignore-line
    }
}
