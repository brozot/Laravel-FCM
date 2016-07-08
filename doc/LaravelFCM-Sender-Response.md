LaravelFCM\Sender\Response
===============

Class Response




* Class name: Response
* Namespace: LaravelFCM\Sender



Constants
----------


### SUCCESS

    const SUCCESS = 'success'





### FAILURE

    const FAILURE = 'failure'





### CANONICAL_IDS

    const CANONICAL_IDS = "canonical_ids"





### RESULTS

    const RESULTS = "results"





### ERROR

    const ERROR = "error"





### MISSING_REGISTRATION

    const MISSING_REGISTRATION = "MissingRegistration"





### INVALID_PACKAGE_NAME

    const INVALID_PACKAGE_NAME = "InvalidPackageName"





### MISMATCH_SENDER_ID

    const MISMATCH_SENDER_ID = "MismatchSenderId"





### MESSAGE_TOO_BIG

    const MESSAGE_TOO_BIG = "MessageTooBig"





### INVALID_DATA_KEY

    const INVALID_DATA_KEY = "InvalidDataKey"





### INVALID_TTL

    const INVALID_TTL = "InvalidTtl"





### MESSAGE_ID

    const MESSAGE_ID = "message_id"





### REGISTRATION_ID

    const REGISTRATION_ID = "registration_id"





### NOT_REGISTERED

    const NOT_REGISTERED = "NotRegistered"





### INVALID_REGISTRATION

    const INVALID_REGISTRATION = "InvalidRegistration"





### UNAVAILABLE

    const UNAVAILABLE = "Unavailable"





### INTERNAL_SERVER_ERROR

    const INTERNAL_SERVER_ERROR = "InternalServerError"





### DEVICE_MESSAGE_RATE_EXCEEDED

    const DEVICE_MESSAGE_RATE_EXCEEDED = "DeviceMessageRateExceeded"





### FAILED_REGISTRATION_IDS

    const FAILED_REGISTRATION_IDS = "failed_registration_ids"





### TOPIC_MESSAGE_RATE_EXCEEDED

    const TOPIC_MESSAGE_RATE_EXCEEDED = "TopicsMessageRateExceeded"







Methods
-------


### __construct

    mixed LaravelFCM\Sender\Response::__construct(\GuzzleHttp\Psr7\Response $response, array|string|null $to)

Response constructor.



* Visibility: **public**


#### Arguments
* $response **GuzzleHttp\Psr7\Response**
* $to **array|string|null**



### numberSuccess

    integer LaravelFCM\Sender\Response::numberSuccess()

get the number of token where the message was sent with success



* Visibility: **public**




### numberFailure

    integer LaravelFCM\Sender\Response::numberFailure()

get the number of token where the  message was not be sent



* Visibility: **public**




### numberModifiedToken

    integer LaravelFCM\Sender\Response::numberModifiedToken()

get the number of token where the notification was sent but that need to be changed



* Visibility: **public**




### tokenToDelete

    array LaravelFCM\Sender\Response::tokenToDelete()

Get a list of token which must be deleted from the database



* Visibility: **public**




### tokenToModify

    array LaravelFCM\Sender\Response::tokenToModify()

Get a list of token that must be modified in the database

key: oldToken
value: new token

* Visibility: **public**




### tokenToRetry

    array LaravelFCM\Sender\Response::tokenToRetry()

Get a list of token that you should retry to send a message

key: oldToken
value: new token

* Visibility: **public**




### failedRegistrationIds

    array LaravelFCM\Sender\Response::failedRegistrationIds()

For group get the list of tokens where the notification was sent but that need to be changed



* Visibility: **public**




### merge

    mixed LaravelFCM\Sender\Response::merge(\LaravelFCM\Sender\Response $response)

Merge two response



* Visibility: **public**


#### Arguments
* $response **[LaravelFCM\Sender\Response](LaravelFCM-Sender-Response.md)**


