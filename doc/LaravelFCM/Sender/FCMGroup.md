# LaravelFCM\Sender\FCMGroup | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>class

>    [LaravelFCM](../../LaravelFCM.md)` / `[Sender](../../LaravelFCM/Sender.md)` / `(FCMGroup)
## FCMGroup

class **FCMGroup**        extends [<abbr title="LaravelFCM\Sender\HTTPSender">HTTPSender</abbr>](../../LaravelFCM/Sender/HTTPSender.md) [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMGroup.php)






### Constants

|   |   |
|---|---|
|CREATE||
|ADD||
|REMOVE||

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
|null|string|<a name="#method_createGroup"></a>createGroup(string $notificationKeyName, array $registrationIds)|Create a group.||
|null|string|<a name="#method_addToGroup"></a>addToGroup(string $notificationKeyName, string $notificationKey, array $registrationIds)|Add registrationIds to an existing group.||
|null|string|<a name="#method_removeFromGroup"></a>removeFromGroup(string $notificationKeyName, string $notificationKey, array $registeredIds)|Remove registeredIds from an existing group.||
|bool|<a name="#method_isValidResponse"></a>isValidResponse(<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr> $response)|No description||


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
<a name id="method_createGroup"></a>

### 
 null|string **createGroup**(string $notificationKeyName, array $registrationIds)

[at line 22](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMGroup.php#L22)

Create a group.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$notificationKeyName||array|$registrationIds|

#### Return Value

|   |   |
|---|---|
|null|string|notification_key

<a name id="method_addToGroup"></a>

### 
 null|string **addToGroup**(string $notificationKeyName, string $notificationKey, array $registrationIds)

[at line 39](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMGroup.php#L39)

Add registrationIds to an existing group.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$notificationKeyName||string|$notificationKey||array|$registrationIds|registrationIds to add

#### Return Value

|   |   |
|---|---|
|null|string|notification_key

<a name id="method_removeFromGroup"></a>

### 
 null|string **removeFromGroup**(string $notificationKeyName, string $notificationKey, array $registeredIds)

[at line 57](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMGroup.php#L57)

Remove registeredIds from an existing group.        >Note: if you remove all registrationIds the group is automatically deleted

#### Parameters

|   |   |   |
|---|---|---|
|string|$notificationKeyName||string|$notificationKey||array|$registeredIds|registrationIds to remove

#### Return Value

|   |   |
|---|---|
|null|string|notification_key

<a name id="method_isValidResponse"></a>

### 
 bool **isValidResponse**(<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr> $response)

[at line 87](https://github.com/code-lts/Laravel-FCM/blob/main/src/Sender/FCMGroup.php#L87)



#### Parameters

|   |   |   |
|---|---|---|
|<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr>|$response|

#### Return Value

|   |   |
|---|---|
|bool|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._