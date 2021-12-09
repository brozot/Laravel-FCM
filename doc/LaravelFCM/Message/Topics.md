# LaravelFCM\Message\Topics | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>class

>    [LaravelFCM](../../LaravelFCM.md)` / `[Message](../../LaravelFCM/Message.md)` / `(Topics)
## Topics

class **Topics** [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php)



Create topic or a topic condition


### Properties

|   |   |   |   |
|---|---|---|---|
|<a name="property_conditions"></a> array|$conditions|||
### Methods

|   |   |   |   |
|---|---|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|<a name="#method_topic"></a>topic(string $first)|Add a topic, this method should be called before any conditional topic.||
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|<a name="#method_orTopic"></a>orTopic(string|[Closure](https://www.php.net/Closure) $first)|Add a or condition to the precedent topic set.||
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|<a name="#method_andTopic"></a>andTopic(string|[Closure](https://www.php.net/Closure) $first)|Add a and condition to the precedent topic set.||
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|<a name="#method_nest"></a>nest([Closure](https://www.php.net/Closure) $callback, string $condition, bool $strict = true)|No description||
|array|string|<a name="#method_build"></a>build()|Transform to array.||
|string|<a name="#method_topicsForFcm"></a>topicsForFcm(array $conditions)|No description||
|bool|<a name="#method_hasOnlyOneTopic"></a>hasOnlyOneTopic()|Check if only one topic was set.||
||<a name="#method_checkIfOneTopicExist"></a>checkIfOneTopicExist()|No description||


### Details
<a name id="method_topic"></a>

### 
 [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) **topic**(string $first)

[at line 28](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L28)

Add a topic, this method should be called before any conditional topic.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$first|topicName

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|

<a name id="method_orTopic"></a>

### 
 [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) **orTopic**(string|[Closure](https://www.php.net/Closure) $first)

[at line 66](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L66)

Add a or condition to the precedent topic set.        Parenthesis is a closure

Equivalent of this: **'TopicA' in topic' || 'TopicB' in topics**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->orTopic('TopicB');
```

Equivalent of this: **'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->andTopic(function($condition) {
                     $condition->topic('TopicB')->orTopic('TopicC');
         });
```

> Note: Only two operators per expression are supported by fcm

#### Parameters

|   |   |   |
|---|---|---|
|string|[Closure](https://www.php.net/Closure)|$first|topicName or closure

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|

<a name id="method_andTopic"></a>

### 
 [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) **andTopic**(string|[Closure](https://www.php.net/Closure) $first)

[at line 100](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L100)

Add a and condition to the precedent topic set.        Parenthesis is a closure

Equivalent of this: **'TopicA' in topic' && 'TopicB' in topics**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->anTopic('TopicB');
```

Equivalent of this: **'TopicA' in topics || ('TopicB' in topics && 'TopicC' in topics)**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->orTopic(function($condition) {
                     $condition->topic('TopicB')->AndTopic('TopicC');
         });
```

> Note: Only two operators per expression are supported by fcm

#### Parameters

|   |   |   |
|---|---|---|
|string|[Closure](https://www.php.net/Closure)|$first|topicName or closure

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|

<a name id="method_nest"></a>

### 
 [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) **nest**([Closure](https://www.php.net/Closure) $callback, string $condition, bool $strict = true)

[at line 136](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L136)



#### Parameters

|   |   |   |
|---|---|---|
|[Closure](https://www.php.net/Closure)|$callback||string|$condition||bool|$strict|Controls if the operators checking is enabled (default to true)

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|

<a name id="method_build"></a>

### 
 array|string **build**()

[at line 167](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L167)

Transform to array.        

#### Return Value

|   |   |
|---|---|
|array|string|


#### Exceptions

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Exceptions\NoTopicProvidedException">NoTopicProvidedException</abbr>](../../LaravelFCM/Message/Exceptions/NoTopicProvidedException.html)||

<a name id="method_topicsForFcm"></a>

### 
protected string **topicsForFcm**(array $conditions)

[at line 189](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L189)



#### Parameters

|   |   |   |
|---|---|---|
|array|$conditions|

#### Return Value

|   |   |
|---|---|
|string|

<a name id="method_hasOnlyOneTopic"></a>

### 
 bool **hasOnlyOneTopic**()

[at line 225](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L225)

Check if only one topic was set.        

#### Return Value

|   |   |
|---|---|
|bool|

<a name id="method_checkIfOneTopicExist"></a>

### 
protected  **checkIfOneTopicExist**()

[at line 235](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L235)



#### Exceptions

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Exceptions\NoTopicProvidedException">NoTopicProvidedException</abbr>](../../LaravelFCM/Message/Exceptions/NoTopicProvidedException.html)||

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._