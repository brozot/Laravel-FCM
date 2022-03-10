<?php

namespace LaravelFCM\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;
use LaravelFCM\FCMServiceProvider;
use PHPUnit\Runner\Version as PHPUnitVersion;

abstract class FCMTestCase extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        $app->register(FCMServiceProvider::class);

        $app['config']['fcm.driver'] = 'http';
        $app['config']['fcm.http.timeout'] = 20;
        $app['config']['fcm.http.server_send_url'] = 'http://test.test';
        $app['config']['fcm.http.server_key'] = 'key=myKey';
        $app['config']['fcm.http.sender_id'] = 'SENDER_ID';

        return $app;
    }

    public function getPhpUnitVersion()
    {
        if (class_exists(PHPUnit_Runner_Version::class)) {
            return (int) explode('.', PHPUnit_Runner_Version::id())[0];
        }
        return (int) explode('.', PHPUnitVersion::id())[0];
    }

    public function setExceptionExpected($className)
    {
        if ($this->getPhpUnitVersion() <= 5) {
            return $this->setExpectedException($className);
        }
        return $this->expectException($className);
    }

    public function setExceptionExpectedMessage($className)
    {
        if ($this->getPhpUnitVersion() <= 4) {
            return $this->setExpectedExceptionRegExp($className);
        }
        return $this->expectExceptionMessage($className);
    }
}
