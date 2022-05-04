# LaravelFCM\Response\DownstreamResponse | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>class

>    [LaravelFCM](../../LaravelFCM.md)` / `[Response](../../LaravelFCM/Response.md)` / `(DownstreamResponse)
## DownstreamResponse

class **DownstreamResponse**        extends [<abbr title="LaravelFCM\Response\BaseResponse">BaseResponse</abbr>](../../LaravelFCM/Response/BaseResponse.md)        implements
        [<abbr title="LaravelFCM\Response\DownstreamResponseContract">DownstreamResponseContract</abbr>](../../LaravelFCM/Response/DownstreamResponseContract.md) [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php)






### Constants

|   |   |
|---|---|
|SUCCESS||
|FAILURE||
|ERROR||
|MESSAGE_ID||
|MULTICAST_ID||
|CANONICAL_IDS||
|RESULTS||
|MISSING_REGISTRATION||
|REGISTRATION_ID||
|NOT_REGISTERED||
|INVALID_REGISTRATION||
|UNAVAILABLE||
|DEVICE_MESSAGE_RATE_EXCEEDED||
|INTERNAL_SERVER_ERROR||

### Properties

|   |   |   |   |
|---|---|---|---|
|<a name="property_logEnabled"></a>protected bool|$logEnabled||<small>from&nbsp;[../../LaravelFCM/Response/BaseResponse.md#property_logEnabled](<abbr title="LaravelFCM\Response\BaseResponse">BaseResponse</abbr>)</small>|
|<a name="property_logger"></a>protected <abbr title="Monolog\Logger">Logger</abbr>|$logger|The logger.|<small>from&nbsp;[../../LaravelFCM/Response/BaseResponse.md#property_logger](<abbr title="LaravelFCM\Response\BaseResponse">BaseResponse</abbr>)</small>|
|<a name="property_numberTokensSuccess"></a>protected int|$numberTokensSuccess|||
|<a name="property_numberTokensFailure"></a>protected int|$numberTokensFailure|||
|<a name="property_numberTokenModify"></a>protected int|$numberTokenModify|||
|<a name="property_messageId"></a>protected string|$messageId|||
|<a name="property_tokensToDelete"></a>protected array|$tokensToDelete|||
|<a name="property_tokensToModify"></a>protected array|$tokensToModify|||
|<a name="property_tokensToRetry"></a>protected array|$tokensToRetry|||
|<a name="property_tokensWithError"></a>protected array|$tokensWithError|||
|<a name="property_hasMissingToken"></a>protected bool|$hasMissingToken|||
### Methods

|   |   |   |   |
|---|---|---|---|
||<a name="#method___construct"></a>__construct(<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr> $response, array|string $tokens, <abbr title="Monolog\Logger">Logger</abbr> $logger)|DownstreamResponse constructor.||
|void|<a name="#method_parseResponse"></a>parseResponse(array $responseInJson)|Parse the response.||
|void|<a name="#method_logResponse"></a>logResponse()|No description||
||<a name="#method_merge"></a>merge([<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md) $response)|Merge two response.||
|int|<a name="#method_numberSuccess"></a>numberSuccess()|Get the number of device reached with success.||
|int|<a name="#method_numberFailure"></a>numberFailure()|Get the number of device which thrown an error.||
|int|<a name="#method_numberModification"></a>numberModification()|Get the number of device that you need to modify their token.||
|array|<a name="#method_tokensToDelete"></a>tokensToDelete()|get token to delete.||
|array|<a name="#method_tokensToModify"></a>tokensToModify()|get token to modify.||
|array|<a name="#method_tokensToRetry"></a>tokensToRetry()|Get tokens that you should resend using exponential backoff.||
|array|<a name="#method_tokensWithError"></a>tokensWithError()|Get tokens that thrown an error.||
|bool|<a name="#method_hasMissingToken"></a>hasMissingToken()|check if missing tokens was given to the request. If true, remove all the empty token in your database.||


### Details
<a name id="method___construct"></a>

### 
  **__construct**(<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr> $response, array|string $tokens, <abbr title="Monolog\Logger">Logger</abbr> $logger)

[at line 98](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L98)

DownstreamResponse constructor.        

#### Parameters

|   |   |   |
|---|---|---|
|<abbr title="Psr\Http\Message\ResponseInterface">ResponseInterface</abbr>|$response||array|string|$tokens||<abbr title="Monolog\Logger">Logger</abbr>|$logger|
<a name id="method_parseResponse"></a>

### 
protected void **parseResponse**(array $responseInJson)

[at line 111](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L111)

Parse the response.        

#### Parameters

|   |   |   |
|---|---|---|
|array|$responseInJson|

#### Return Value

|   |   |
|---|---|
|void|

<a name id="method_logResponse"></a>

### 
protected void **logResponse**()

[at line 293](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L293)



#### Return Value

|   |   |
|---|---|
|void|

<a name id="method_merge"></a>

### 
  **merge**([<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md) $response)

[at line 309](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L309)

Merge two response.        

#### Parameters

|   |   |   |
|---|---|---|
|[<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md)|$response|
<a name id="method_numberSuccess"></a>

### 
 int **numberSuccess**()

[at line 326](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L326)

Get the number of device reached with success.        

#### Return Value

|   |   |
|---|---|
|int|

<a name id="method_numberFailure"></a>

### 
 int **numberFailure**()

[at line 336](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L336)

Get the number of device which thrown an error.        

#### Return Value

|   |   |
|---|---|
|int|

<a name id="method_numberModification"></a>

### 
 int **numberModification**()

[at line 346](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L346)

Get the number of device that you need to modify their token.        

#### Return Value

|   |   |
|---|---|
|int|

<a name id="method_tokensToDelete"></a>

### 
 array **tokensToDelete**()

[at line 358](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L358)

get token to delete.        remove all tokens returned by this method in your database

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_tokensToModify"></a>

### 
 array **tokensToModify**()

[at line 373](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L373)

get token to modify.        key: oldToken
value: new token

find the old token in your database and replace it with the new one

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_tokensToRetry"></a>

### 
 array **tokensToRetry**()

[at line 383](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L383)

Get tokens that you should resend using exponential backoff.        

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_tokensWithError"></a>

### 
 array **tokensWithError**()

[at line 398](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L398)

Get tokens that thrown an error.        key : token
value : error

In production, remove these tokens from you database

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_hasMissingToken"></a>

### 
 bool **hasMissingToken**()

[at line 409](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponse.php#L409)

check if missing tokens was given to the request
If true, remove all the empty token in your database.        

#### Return Value

|   |   |
|---|---|
|bool|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._