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
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|<a name="#method_nest"></a>nest([Closure](https://www.php.net/Closure) $callback, string $condition)|No description||
|array|string|<a name="#method_build"></a>build()|Transform to array.||
|bool|<a name="#method_hasOnlyOneTopic"></a>hasOnlyOneTopic()|Check if only one topic was set.||


### Details
<a name id="method_topic"></a>

### 
 [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) **topic**(string $first)

[at line 27](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L27)

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

[at line 65](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L65)

Add a or condition to the precedent topic set.        Parenthesis is a closure</p>

<p>Equivalent of this: <strong>'TopicA' in topic' || 'TopicB' in topics</strong></p>

<pre><code>         $topic = new Topics();
         $topic-&gt;topic('TopicA')
               -&gt;orTopic('TopicB');
</code></pre>

<p>Equivalent of this: <strong>'TopicA' in topics &amp;&amp; ('TopicB' in topics || 'TopicC' in topics)</strong></p>

<pre><code>         $topic = new Topics();
         $topic-&gt;topic('TopicA')
               -&gt;andTopic(function($condition) {
                     $condition-&gt;topic('TopicB')-&gt;orTopic('TopicC');
         });
</code></pre>

<blockquote>
  <p>Note: Only two operators per expression are supported by fcm</p>
</blockquote>


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

[at line 99](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L99)

Add a and condition to the precedent topic set.        Parenthesis is a closure</p>

<p>Equivalent of this: <strong>'TopicA' in topic' &amp;&amp; 'TopicB' in topics</strong></p>

<pre><code>         $topic = new Topics();
         $topic-&gt;topic('TopicA')
               -&gt;anTopic('TopicB');
</code></pre>

<p>Equivalent of this: <strong>'TopicA' in topics || ('TopicB' in topics &amp;&amp; 'TopicC' in topics)</strong></p>

<pre><code>         $topic = new Topics();
         $topic-&gt;topic('TopicA')
               -&gt;orTopic(function($condition) {
                     $condition-&gt;topic('TopicB')-&gt;AndTopic('TopicC');
         });
</code></pre>

<blockquote>
  <p>Note: Only two operators per expression are supported by fcm</p>
</blockquote>


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
 [<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md) **nest**([Closure](https://www.php.net/Closure) $callback, string $condition)

[at line 134](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L134)



#### Parameters

|   |   |   |
|---|---|---|
|[Closure](https://www.php.net/Closure)|$callback||string|$condition|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Topics">Topics</abbr>](../../LaravelFCM/Message/Topics.md)|

<a name id="method_build"></a>

### 
 array|string **build**()

[at line 159](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L159)

Transform to array.        

#### Return Value

|   |   |
|---|---|
|array|string|


#### Exceptions

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\Exceptions\NoTopicProvidedException">NoTopicProvidedException</abbr>](../../LaravelFCM/Message/Exceptions/NoTopicProvidedException.html)||

<a name id="method_hasOnlyOneTopic"></a>

### 
 bool **hasOnlyOneTopic**()

[at line 215](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/Topics.php#L215)

Check if only one topic was set.        

#### Return Value

|   |   |
|---|---|
|bool|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._