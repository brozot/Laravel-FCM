<?php

namespace LaravelFCM\Response;

use LaravelFCM\Message\Topics;
use Psr\Http\Message\ResponseInterface;
use Monolog\Logger;

class TopicResponse extends BaseResponse implements TopicResponseContract
{
    const LIMIT_RATE_TOPICS_EXCEEDED = 'TopicsMessageRateExceeded';

    /**
     * @internal
     *
     * @var Topics
     */
    protected $topic;

    /**
     * @internal
     *
     * @var string
     */
    protected $messageId;

    /**
     * @internal
     *
     * @var string
     */
    protected $error;

    /**
     * @internal
     *
     * @var bool
     */
    protected $needRetry = false;

    /**
     * TopicResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Topics         $topic
     */
    public function __construct(ResponseInterface $response, Topics $topic, Logger $logger)
    {
        $this->topic = $topic;
        parent::__construct($response, $logger);
    }

    /**
     * parse the response.
     *
     * @param array $responseInJson
     * @return void
     */
    protected function parseResponse($responseInJson)
    {
        if (!$this->parseSuccess($responseInJson)) {
            //TODO: fix this bug
            $this->parseError($responseInJson);
        }

        if ($this->logEnabled) {
            $this->logResponse();
        }
    }

    /**
     * @internal
     *
     * @param array $responseInJson
     * @return void
     */
    private function parseSuccess($responseInJson)
    {
        if (array_key_exists(self::MESSAGE_ID, $responseInJson)) {
            $this->messageId = $responseInJson[ self::MESSAGE_ID ];
        }
    }

    /**
     * @internal
     *
     * @param array $responseInJson
     * @return void
     */
    private function parseError($responseInJson)
    {
        if (array_key_exists(self::ERROR, $responseInJson)) {
            if (in_array(self::LIMIT_RATE_TOPICS_EXCEEDED, $responseInJson)) {
                $this->needRetry = true;
            }

            $this->error = $responseInJson[ self::ERROR ];
        }
    }

    /**
     * Log the response.
     *
     * @return void
     */
    protected function logResponse()
    {
        $topic = $this->topic->build();

        $logMessage = 'notification send to topic: ' . json_encode($topic);
        if ($this->messageId) {
            $logMessage .= "with success (message-id : $this->messageId)";
        } else {
            $logMessage .= "with error (error : $this->error)";
        }

        $this->logger->info($logMessage);
    }

    /**
     * true if topic sent with success.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return (bool) $this->messageId;
    }

    /**
     * return error message
     * you should test if it's necessary to resent it.
     *
     * @return string error
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * return true if it's necessary resent it using exponential backoff.
     *
     * @return bool
     */
    public function shouldRetry()
    {
        return $this->needRetry;
    }
}
