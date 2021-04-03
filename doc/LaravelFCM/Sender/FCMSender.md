# LaravelFCM\Sender\FCMSender | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>class

>    [LaravelFCM](../../LaravelFCM.md)` / `[Sender](../../LaravelFCM/Sender.md)` / `(FCMSender)
## FCMSender

class **FCMSender**        extends [<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>](../../LaravelFCM/Sender/HTTPSender.md) [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMSender.php)






### Constants

|   |   |
|---|---|
|MAX_TOKEN_PER_REQUEST||

### Properties

|   |   |   |   |
|---|---|---|---|
|<a name="property_client"></a>protected <abbr title="GuzzleHttp\ClientInterface">ClientInterface</abbr>|$client|The client used to send messages.|<small>from&nbsp;[../../LaravelFCM/Sender/HTTPSender.md#property_client](<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>)</small>|
|<a name="property_url"></a>protected string|$url|The URL entry point.|<small>from&nbsp;[../../LaravelFCM/Sender/HTTPSender.md#property_url](<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>)</small>|
|<a name="property_logger"></a>protected <abbr title="Monolog\Logger">Logger</abbr>|$logger|The logger.|<small>from&nbsp;[../../LaravelFCM/Sender/HTTPSender.md#property_logger](<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>)</small>|
### Methods

|   |   |   |   |
|---|---|---|---|
||<a name="#method___construct"></a>__construct(<abbr title="GuzzleHttp\ClientInterface">ClientInterface</abbr> $client, string $url, <abbr title="Monolog\Logger">Logger</abbr> $logger)|Initializes a new sender object.|from&nbsp;[../../LaravelFCM/Sender/HTTPSender.md#method___construct](<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>)|
|[<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md)|null|<a name="#method_sendTo"></a>sendTo(string|array $to, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null)|send a downstream message to.||
|[<abbr title="LaravelFCM\Response\GroupResponse">GroupResponse</abbr>](../../LaravelFCM/Response/GroupResponse.md)|<a name="#method_sendToGroup"></a>sendToGroup(string|string[] $notificationKey, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null)|Send a message to a group of devices identified with them notification key.||
|[<abbr title="LaravelFCM\Response\TopicResponse">TopicResponse</abbr>](../../LaravelFCM/Response/TopicResponse.md)|<a name="#method_sendToTopic"></a>sendToTopic([<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) $topics, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null)|Send message devices registered at a or more topics.||
|null|<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr>|<a name="#method_post"></a>post([<abbr title="LaravelFCM\Request\Request">Request</abbr>](../../LaravelFCM/Request/Request.md) $request)|No description||


### Details
<a name id="method___construct"></a>

### 
  **__construct**(<abbr title="GuzzleHttp\ClientInterface">ClientInterface</abbr> $client, string $url, <abbr title="Monolog\Logger">Logger</abbr> $logger)in [../../LaravelFCM/Sender/HTTPSender.md#method___construct](<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>)

[at line 37](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/HTTPSender.php#L37)

Initializes a new sender object.        

#### Parameters

|   |   |   |
|---|---|---|
|<abbr title="GuzzleHttp\ClientInterface">ClientInterface</abbr>|$client||string|$url||<abbr title="Monolog\Logger">Logger</abbr>|$logger|
<a name id="method_sendTo"></a>

### 
 [<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md)|null **sendTo**(string|array $to, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null)

[at line 32](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMSender.php#L32)

send a downstream message to.        <ul>
<li>a unique device with is registration Token</li>
<li>or to multiples devices with an array of registrationIds</li>
</ul>


#### Parameters

|   |   |   |
|---|---|---|
|string|array|$to||[<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md)|$options||[<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|$notification||[<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md)|$data|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md)|null|

<a name id="method_sendToGroup"></a>

### 
 [<abbr title="LaravelFCM\Response\GroupResponse">GroupResponse</abbr>](../../LaravelFCM/Response/GroupResponse.md) **sendToGroup**(string|string[] $notificationKey, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null)

[at line 70](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMSender.php#L70)

Send a message to a group of devices identified with them notification key.        

#### Parameters

|   |   |   |
|---|---|---|
|string|string[]|$notificationKey||[<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md)|$options||[<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|$notification||[<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md)|$data|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Response\GroupResponse">GroupResponse</abbr>](../../LaravelFCM/Response/GroupResponse.md)|

<a name id="method_sendToTopic"></a>

### 
 [<abbr title="LaravelFCM\Response\TopicResponse">TopicResponse</abbr>](../../LaravelFCM/Response/TopicResponse.md) **sendToTopic**([<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) $topics, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null)

[at line 89](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMSender.php#L89)

Send message devices registered at a or more topics.        

#### Parameters

|   |   |   |
|---|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|$topics||[<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md)|$options||[<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|$notification||[<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md)|$data|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Response\TopicResponse">TopicResponse</abbr>](../../LaravelFCM/Response/TopicResponse.md)|

<a name id="method_post"></a>

### 
protected null|<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr> **post**([<abbr title="LaravelFCM\Request\Request">Request</abbr>](../../LaravelFCM/Request/Request.md) $request)

[at line 105](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMSender.php#L105)



#### Parameters

|   |   |   |
|---|---|---|
|[<abbr title="LaravelFCM\Request\Request">Request</abbr>](../../LaravelFCM/Request/Request.md)|$request|

#### Return Value

|   |   |
|---|---|
|null|<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr>|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._