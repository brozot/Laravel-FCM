<?php

namespace LaravelFCM\Request;

/**
 * Class GroupRequest.
 */
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
    protected $notificationKeyName;

    /**
     * @internal
     *
     * @var string
     */
    protected $notificationKey;

    /**
     * @internal
     *
     * @var array
     */
    protected $registrationIds;

    /**
     * GroupRequest constructor.
     *
     * @param $operation
     * @param $notificationKeyName
     * @param $notificationKey
     * @param $registrationIds
     */
    public function __construct($operation, $topic_id, $recipients_tokens = [])
    {
        parent::__construct();

        if (!is_array($recipients_tokens)){
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
        if($this->operation == 'create'){
            return [];
        }

        return [
            'to' => '/topics/' . $this->topic_id,
            'registration_tokens' => $this->recipients_tokens,
        ];
    }
}
