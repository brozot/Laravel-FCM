# LaravelFCM\Request\Request | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>class

>    [LaravelFCM](../../LaravelFCM.md)` / `[Request](../../LaravelFCM/Request.md)` / `(Request)
## Request

class **Request**        extends [<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>](../../LaravelFCM/Request/BaseRequest.md) [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php)






### Properties

|   |   |   |   |
|---|---|---|---|
|<a name="property_client"></a>protected <abbr title="GuzzleHttp\ClientInterface">ClientInterface</abbr>|$client||<small>from&nbsp;[../../LaravelFCM/Request/BaseRequest.md#property_client](<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>)</small>|
|<a name="property_config"></a>protected array|$config||<small>from&nbsp;[../../LaravelFCM/Request/BaseRequest.md#property_config](<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>)</small>|
|<a name="property_to"></a>protected string|array|$to|||
|<a name="property_options"></a>protected [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md)|$options|||
|<a name="property_notification"></a>protected [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|$notification|||
|<a name="property_data"></a>protected [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md)|$data|||
|<a name="property_topic"></a>protected [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|null|$topic|||
### Methods

|   |   |   |   |
|---|---|---|---|
||<a name="#method___construct"></a>__construct(string|array $to, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null, [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) $topic = null)|Request constructor.||
|array|<a name="#method_buildRequestHeader"></a>buildRequestHeader()|Build the header for the request.|from&nbsp;[../../LaravelFCM/Request/BaseRequest.md#method_buildRequestHeader](<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>)|
|mixed|<a name="#method_buildBody"></a>buildBody()|Build the body for the request.||
|array|<a name="#method_build"></a>build()|Return the request in array form.|from&nbsp;[../../LaravelFCM/Request/BaseRequest.md#method_build](<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>)|
|array|null|string|<a name="#method_getTo"></a>getTo()|get to key transformed.||
|array|null|<a name="#method_getRegistrationIds"></a>getRegistrationIds()|get registrationIds transformed.||
|array|<a name="#method_getOptions"></a>getOptions()|get Options transformed.||
|array|null|<a name="#method_getNotification"></a>getNotification()|get notification transformed.||
|array|null|<a name="#method_getData"></a>getData()|get data transformed.||


### Details
<a name id="method___construct"></a>

### 
  **__construct**(string|array $to, [<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md) $options = null, [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) $notification = null, [<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md) $data = null, [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) $topic = null)

[at line 56](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L56)

Request constructor.        

#### Parameters

|   |   |   |
|---|---|---|
|string|array|$to||[<abbr title="LaravelFCM\Message\Options">Options</abbr>](../../LaravelFCM/Message/Options.md)|$options||[<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|$notification||[<abbr title="LaravelFCM\Message\PayloadData">PayloadData</abbr>](../../LaravelFCM/Message/PayloadData.md)|$data||[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|$topic|
<a name id="method_buildRequestHeader"></a>

### 
protected array **buildRequestHeader**()in [../../LaravelFCM/Request/BaseRequest.md#method_buildRequestHeader](<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>)

[at line 34](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/BaseRequest.php#L34)

Build the header for the request.        

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_buildBody"></a>

### 
protected mixed **buildBody**()

[at line 72](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L72)

Build the body for the request.        

#### Return Value

|   |   |
|---|---|
|mixed|

<a name id="method_build"></a>

### 
 array **build**()in [../../LaravelFCM/Request/BaseRequest.md#method_build](<abbr title="LaravelFCM\Request\BaseRequest">BaseRequest</abbr>)

[at line 55](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/BaseRequest.php#L55)

Return the request in array form.        

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_getTo"></a>

### 
protected array|null|string **getTo**()

[at line 92](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L92)

get to key transformed.        

#### Return Value

|   |   |
|---|---|
|array|null|string|

<a name id="method_getRegistrationIds"></a>

### 
protected array|null **getRegistrationIds**()

[at line 108](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L108)

get registrationIds transformed.        

#### Return Value

|   |   |
|---|---|
|array|null|

<a name id="method_getOptions"></a>

### 
protected array **getOptions**()

[at line 118](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L118)

get Options transformed.        

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_getNotification"></a>

### 
protected array|null **getNotification**()

[at line 134](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L134)

get notification transformed.        

#### Return Value

|   |   |
|---|---|
|array|null|

<a name id="method_getData"></a>

### 
protected array|null **getData**()

[at line 144](https://github.com/code-lts/Laravel-FCM/blob/main/src/Request/Request.php#L144)

get data transformed.        

#### Return Value

|   |   |
|---|---|
|array|null|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._