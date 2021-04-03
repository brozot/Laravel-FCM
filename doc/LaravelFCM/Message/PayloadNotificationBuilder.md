# LaravelFCM\Message\PayloadNotificationBuilder | Laravel / Lumen package for Firebase Cloud Messaging    

## [Laravel / Lumen package for Firebase Cloud Messaging](../../index.md)

- [Classes](../../classes.md)
- [Namespaces](../../namespaces.md)
- [Interfaces](../../interfaces.md)
- [Traits](../../traits.md)
- [Index](../../doc-index.md)
- [Search](../../search.md)

>class

>    [LaravelFCM](../../LaravelFCM.md)` / `[Message](../../LaravelFCM/Message.md)` / `(PayloadNotificationBuilder)
## PayloadNotificationBuilder

class **PayloadNotificationBuilder** [View source](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php)



Official google documentation :


### Properties

|   |   |   |   |
|---|---|---|---|
|<a name="property_title"></a>protected null|string|$title|||
|<a name="property_body"></a>protected null|string|$body|||
|<a name="property_icon"></a>protected null|string|$icon|||
|<a name="property_image"></a>protected null|string|$image|||
|<a name="property_sound"></a>protected null|string|$sound|||
|<a name="property_channelId"></a>protected null|string|$channelId|||
|<a name="property_badge"></a>protected null|string|$badge|||
|<a name="property_tag"></a>protected null|string|$tag|||
|<a name="property_color"></a>protected null|string|$color|||
|<a name="property_clickAction"></a>protected null|string|$clickAction|||
|<a name="property_bodyLocationKey"></a>protected null|string|$bodyLocationKey|||
|<a name="property_bodyLocationArgs"></a>protected null|string|$bodyLocationArgs|||
|<a name="property_titleLocationKey"></a>protected null|string|$titleLocationKey|||
|<a name="property_titleLocationArgs"></a>protected null|string|$titleLocationArgs|||
### Methods

|   |   |   |   |
|---|---|---|---|
||<a name="#method___construct"></a>__construct(string $title = null)|Title must be present on android notification and ios (watch) notification.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setTitle"></a>setTitle(string $title)|Indicates notification title. This field is not visible on iOS phones and tablets.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setBody"></a>setBody(string $body)|Indicates notification body text.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setChannelId"></a>setChannelId(string $channelId)|Set a channel ID for android API &gt;= 26.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setIcon"></a>setIcon(string $icon)|Supported Android. Indicates notification icon. example : Sets value to myicon for drawable resource myicon.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setImage"></a>setImage(null|string $image)|Supported Android. Indicates the image that can be displayed in the notification. Supports an url or internal image.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setSound"></a>setSound(string $sound)|Indicates a sound to play when the device receives a notification.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setBadge"></a>setBadge(string $badge)|Supported Ios.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setTag"></a>setTag(string $tag)|Supported Android.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setColor"></a>setColor(string $color)|Supported Android.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setClickAction"></a>setClickAction(string $action)|Indicates the action associated with a user click on the notification.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setTitleLocationKey"></a>setTitleLocationKey(string $titleKey)|Indicates the key to the title string for localization.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setTitleLocationArgs"></a>setTitleLocationArgs(mixed $titleArgs)|Indicates the string value to replace format specifiers in the title string for localization.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setBodyLocationKey"></a>setBodyLocationKey(string $bodyKey)|Indicates the key to the body string for localization.||
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|<a name="#method_setBodyLocationArgs"></a>setBodyLocationArgs(mixed $bodyArgs)|Indicates the string value to replace format specifiers in the body string for localization.||
|null|string|<a name="#method_getTitle"></a>getTitle()|Get title.||
|null|string|<a name="#method_getBody"></a>getBody()|Get body.||
|null|string|<a name="#method_getChannelId"></a>getChannelId()|Get channel id for android api &gt;= 26||
|null|string|<a name="#method_getIcon"></a>getIcon()|Get Icon.||
|string|null|<a name="#method_getImage"></a>getImage()|Get Image.||
|null|string|<a name="#method_getSound"></a>getSound()|Get Sound.||
|null|string|<a name="#method_getBadge"></a>getBadge()|Get Badge.||
|null|string|<a name="#method_getTag"></a>getTag()|Get Tag.||
|null|string|<a name="#method_getColor"></a>getColor()|Get Color.||
|null|string|<a name="#method_getClickAction"></a>getClickAction()|Get ClickAction.||
|null|string|<a name="#method_getBodyLocationKey"></a>getBodyLocationKey()|Get BodyLocationKey.||
|null|string|array|<a name="#method_getBodyLocationArgs"></a>getBodyLocationArgs()|Get BodyLocationArgs.||
|string|<a name="#method_getTitleLocationKey"></a>getTitleLocationKey()|Get TitleLocationKey.||
|null|string|array|<a name="#method_getTitleLocationArgs"></a>getTitleLocationArgs()|GetTitleLocationArgs.||
|[<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|<a name="#method_build"></a>build()|Build an PayloadNotification.||


### Details
<a name id="method___construct"></a>

### 
  **__construct**(string $title = null)

[at line 116](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L116)

Title must be present on android notification and ios (watch) notification.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$title|
<a name id="method_setTitle"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setTitle**(string $title)

[at line 129](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L129)

Indicates notification title. This field is not visible on iOS phones and tablets.        but it is required for android.

#### Parameters

|   |   |   |
|---|---|---|
|string|$title|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setBody"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setBody**(string $body)

[at line 143](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L143)

Indicates notification body text.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$body|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setChannelId"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setChannelId**(string $channelId)

[at line 157](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L157)

Set a channel ID for android API >= 26.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$channelId|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setIcon"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setIcon**(string $icon)

[at line 172](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L172)

Supported Android
Indicates notification icon. example : Sets value to myicon for drawable resource myicon.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$icon|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setImage"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setImage**(null|string $image)

[at line 188](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L188)

Supported Android
Indicates the image that can be displayed in the notification
Supports an url or internal image.        

#### Parameters

|   |   |   |
|---|---|---|
|null|string|$image|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setSound"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setSound**(string $sound)

[at line 203](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L203)

Indicates a sound to play when the device receives a notification.        Supports default or the filename of a sound resource bundled in the app.

#### Parameters

|   |   |   |
|---|---|---|
|string|$sound|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setBadge"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setBadge**(string $badge)

[at line 219](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L219)

Supported Ios.        Indicates the badge on the client app home icon.

#### Parameters

|   |   |   |
|---|---|---|
|string|$badge|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setTag"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setTag**(string $tag)

[at line 237](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L237)

Supported Android.        Indicates whether each notification results in a new entry in the notification drawer on Android.
If not set, each request creates a new notification.
If set, and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.

#### Parameters

|   |   |   |
|---|---|---|
|string|$tag|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setColor"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setColor**(string $color)

[at line 253](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L253)

Supported Android.        Indicates color of the icon, expressed in #rrggbb format

#### Parameters

|   |   |   |
|---|---|---|
|string|$color|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setClickAction"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setClickAction**(string $action)

[at line 267](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L267)

Indicates the action associated with a user click on the notification.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$action|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setTitleLocationKey"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setTitleLocationKey**(string $titleKey)

[at line 281](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L281)

Indicates the key to the title string for localization.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$titleKey|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setTitleLocationArgs"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setTitleLocationArgs**(mixed $titleArgs)

[at line 295](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L295)

Indicates the string value to replace format specifiers in the title string for localization.        

#### Parameters

|   |   |   |
|---|---|---|
|mixed|$titleArgs|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setBodyLocationKey"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setBodyLocationKey**(string $bodyKey)

[at line 309](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L309)

Indicates the key to the body string for localization.        

#### Parameters

|   |   |   |
|---|---|---|
|string|$bodyKey|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_setBodyLocationArgs"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md) **setBodyLocationArgs**(mixed $bodyArgs)

[at line 323](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L323)

Indicates the string value to replace format specifiers in the body string for localization.        

#### Parameters

|   |   |   |
|---|---|---|
|mixed|$bodyArgs|

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotificationBuilder">PayloadNotificationBuilder</abbr>](../../LaravelFCM/Message/PayloadNotificationBuilder.md)|current instance of the builder

<a name id="method_getTitle"></a>

### 
 null|string **getTitle**()

[at line 335](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L335)

Get title.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getBody"></a>

### 
 null|string **getBody**()

[at line 345](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L345)

Get body.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getChannelId"></a>

### 
 null|string **getChannelId**()

[at line 355](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L355)

Get channel id for android api >= 26        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getIcon"></a>

### 
 null|string **getIcon**()

[at line 365](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L365)

Get Icon.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getImage"></a>

### 
 string|null **getImage**()

[at line 375](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L375)

Get Image.        

#### Return Value

|   |   |
|---|---|
|string|null|

<a name id="method_getSound"></a>

### 
 null|string **getSound**()

[at line 385](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L385)

Get Sound.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getBadge"></a>

### 
 null|string **getBadge**()

[at line 395](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L395)

Get Badge.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getTag"></a>

### 
 null|string **getTag**()

[at line 405](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L405)

Get Tag.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getColor"></a>

### 
 null|string **getColor**()

[at line 415](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L415)

Get Color.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getClickAction"></a>

### 
 null|string **getClickAction**()

[at line 425](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L425)

Get ClickAction.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getBodyLocationKey"></a>

### 
 null|string **getBodyLocationKey**()

[at line 435](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L435)

Get BodyLocationKey.        

#### Return Value

|   |   |
|---|---|
|null|string|

<a name id="method_getBodyLocationArgs"></a>

### 
 null|string|array **getBodyLocationArgs**()

[at line 445](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L445)

Get BodyLocationArgs.        

#### Return Value

|   |   |
|---|---|
|null|string|array|

<a name id="method_getTitleLocationKey"></a>

### 
 string **getTitleLocationKey**()

[at line 455](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L455)

Get TitleLocationKey.        

#### Return Value

|   |   |
|---|---|
|string|

<a name id="method_getTitleLocationArgs"></a>

### 
 null|string|array **getTitleLocationArgs**()

[at line 465](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L465)

GetTitleLocationArgs.        

#### Return Value

|   |   |
|---|---|
|null|string|array|

<a name id="method_build"></a>

### 
 [<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md) **build**()

[at line 475](https://github.com/code-lts/Laravel-FCM/blob/main/src/Message/PayloadNotificationBuilder.php#L475)

Build an PayloadNotification.        

#### Return Value

|   |   |
|---|---|
|[<abbr title="LaravelFCM\Message\PayloadNotification">PayloadNotification</abbr>](../../LaravelFCM/Message/PayloadNotification.md)|

_Generated by [Doctum, a API Documentation generator and fork of Sami](https://github.com/code-lts/doctum)._