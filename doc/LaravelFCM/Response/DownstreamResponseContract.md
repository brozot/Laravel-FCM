# LaravelFCM\Response\DownstreamResponseContract | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>interface

>    [LaravelFCM](../../LaravelFCM.md)` / `[Response](../../LaravelFCM/Response.md)` / `(DownstreamResponseContract)
## DownstreamResponseContract

interface **DownstreamResponseContract** [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php)



Interface DownstreamResponseContract.


### Methods

|   |   |   |   |
|---|---|---|---|
||<a name="#method_merge"></a>merge([<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md) $response)|Merge two response.||
|int|<a name="#method_numberSuccess"></a>numberSuccess()|Get the number of device reached with success.||
|int|<a name="#method_numberFailure"></a>numberFailure()|Get the number of device which thrown an error.||
|int|<a name="#method_numberModification"></a>numberModification()|Get the number of device that you need to modify their token.||
|array|<a name="#method_tokensToDelete"></a>tokensToDelete()|get token to delete.||
|array|<a name="#method_tokensToModify"></a>tokensToModify()|get token to modify.||
|array|<a name="#method_tokensToRetry"></a>tokensToRetry()|Get tokens that you should resend using exponential backoof.||
|array|<a name="#method_tokensWithError"></a>tokensWithError()|Get tokens that thrown an error.||
|bool|<a name="#method_hasMissingToken"></a>hasMissingToken()|check if missing tokens was given to the request. If true, remove all the empty token in your database.||


### Details
<a name id="method_merge"></a>

### 
  **merge**([<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md) $response)

[at line 15](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L15)

Merge two response.        

#### Parameters

|   |   |   |
|---|---|---|
|[<abbr title="LaravelFCM\Response\DownstreamResponse">DownstreamResponse</abbr>](../../LaravelFCM/Response/DownstreamResponse.md)|$response|
<a name id="method_numberSuccess"></a>

### 
 int **numberSuccess**()

[at line 22](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L22)

Get the number of device reached with success.        

#### Return Value

|   |   |
|---|---|
|int|

<a name id="method_numberFailure"></a>

### 
 int **numberFailure**()

[at line 29](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L29)

Get the number of device which thrown an error.        

#### Return Value

|   |   |
|---|---|
|int|

<a name id="method_numberModification"></a>

### 
 int **numberModification**()

[at line 36](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L36)

Get the number of device that you need to modify their token.        

#### Return Value

|   |   |
|---|---|
|int|

<a name id="method_tokensToDelete"></a>

### 
 array **tokensToDelete**()

[at line 45](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L45)

get token to delete.        remove all tokens returned by this method in your database

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_tokensToModify"></a>

### 
 array **tokensToModify**()

[at line 57](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L57)

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

[at line 64](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L64)

Get tokens that you should resend using exponential backoof.        

#### Return Value

|   |   |
|---|---|
|array|

<a name id="method_tokensWithError"></a>

### 
 array **tokensWithError**()

[at line 76](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L76)

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

[at line 84](https://github.com/code-lts/Laravel-FCM/blob/main/src/Response/DownstreamResponseContract.php#L84)

check if missing tokens was given to the request
If true, remove all the empty token in your database.        

#### Return Value

|   |   |
|---|---|
|bool|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._