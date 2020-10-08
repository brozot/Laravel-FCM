<?php

namespace LaravelFCM\Validator;

use GuzzleHttp\ClientInterface;
use LaravelFCM\Request\ValidateRequest;
use LaravelFCM\Sender\HTTPSender;
use Monolog\Logger;
use \Exception;

class FCMValidator extends HTTPSender {
    private $validate_token_url = 'https://iid.googleapis.com/iid/info/'; // + YOUR_APP_TOKEN_HERE

    /**
     * @param string $token
     *
     * @return bool
     */
    public function validateToken($token) {
        $request = new ValidateRequest();
        try {
            $build = $request->build();
            if (isset($build['json'])) {
                unset($build['json']);
            }
            $this->client->request('get', $this->validate_token_url . $token, $build);
            return true;
        }catch (Exception $e) {
            return false;
        }
    }
}
