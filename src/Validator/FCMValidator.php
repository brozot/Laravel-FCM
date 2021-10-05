<?php

namespace LaravelFCM\Validator;

use LaravelFCM\Request\ValidateRequest;
use LaravelFCM\Sender\HTTPSender;
use \Exception;
use Psr\Http\Message\ResponseInterface;

class FCMValidator extends HTTPSender {

    private $validate_token_url = 'https://iid.googleapis.com/iid/info/'; // + YOUR_APP_TOKEN_HERE

    /**
     * @see https://developers.google.com/instance-id/reference/server
     *
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
            return $this->isValidResponse($this->client->request('get', $this->validate_token_url . $token, $build));
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function isValidResponse(ResponseInterface $response)
    {
        return $response->getStatusCode() === 200;
    }
}
