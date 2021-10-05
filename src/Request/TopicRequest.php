<?php

namespace LaravelFCM\Request;

class TopicRequest extends BaseRequest
{
    /**
     * @internal
     *
     * @var string
     */
    protected $operation;

    /**
     * @internal
     *
     * @var string
     */
    protected $topic_id;

    /**
     * @internal
     *
     * @var array
     */
    protected $recipients_tokens;

    /**
     * TopicRequest constructor.
     *
     * @param string $operation The operation name
     * @param string $topic_id The topic id
     * @param array|string $recipients_tokens The tokens or the token
     */
    public function __construct($operation, $topic_id, $recipients_tokens = [])
    {
        parent::__construct();

        if (! is_array($recipients_tokens)){
            $recipients_tokens = [$recipients_tokens];
        }

        $this->topic_id = $topic_id;
        $this->recipients_tokens = $recipients_tokens;
        $this->operation = $operation;
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildBody()
    {
        if ($this->operation === 'create') {
            return [];
        }

        return [
            'to' => '/topics/' . $this->topic_id,
            'registration_tokens' => $this->recipients_tokens,
        ];
    }
}
