# Laravel-FCM

[![Build Status](https://travis-ci.org/brozot/Laravel-FCM.svg?branch=master)](https://travis-ci.org/brozot/Laravel-FCM)

## Introduction

Laravel-FCM is easy to use package working with Laravel and Lumen for sending push notification with [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/).
It currently support :

**Http protocol**

- Downstream notification with multicast
- Group notification

The XMPP protocol is not currently supported.

## Installation

To get the latest Laravel-FCM on your project, simply require it from composer.

```
$ composer require brozot/laravel-fcm
```

or you can add it directly in your composer.json file:

```
{
    "require": {
        "brozot/laravel-fcm": "^0.9.1"
    }
}
```

### Laravel

Register the provider directly in your app configuration file ```config/app.php```

```
'providers' => [
	...
	
	LaravelFCM\FCMServiceProvider::class 
]
```

Add the facades in the same file.

You need to add the facade FCMGroup, only if you want manage group in your application.

```
'aliases' => [
	...
	'FCM'      => LaravelFCM\Facades\FCM::class,
	'FCMGroup' => LaravelFCM\Facades\FCMGroup::class, // Optional
]
```

Publish the fcm config file with the following command

```
$ php artisan vendor:publish
```

### Lumen

Register the provider in your boostrap app file ```boostrap/app.php```

Add the following line in the "Register Service Providers"  section at the bottom of the file. 

```
$app->register(LaravelFCM\FCMServiceProvider::class);
```

For facades, add the following lines in the "Create The Application" section. FCMGroup facade is only necessary if you want to use group notification in your application.


```
$app->withFacades(); // should be uncommented
class_alias(\LaravelFCM\Facades\FCM::class, 'FCM');
class_alias(\LaravelFCM\Facades\FCMGroup::class, 'FCMGroup');
```

Copy config file ```fcm.php``` manualy from the directory ```/vendor/brozot/laravel-fcm/config``` to the directory ```/config ``` (you may need create this directory).


### Configure package 

In your ```.env``` file add the server and secret key for Firabase cloud messaging.

```
FCM_SERVER_KEY=my_secret_server_key
FCM_SENDER_ID=my_secret_sender_id
```

To get theses keys, you should before creating an new application on [the firebase cloud messagin console](https://console.firebase.google.com/).

After the creation of your application on firebase, you can find theses key in project settings -> cloud messaging

## Basic usage

Sending notification :

With Laravel-FCM, you can send two types of messages:

- Notification messages, sometimes thought of as "display messages."
- Data messages, which are handled by the client app.

you can find more information with the [official documentation](https://firebase.google.com/docs/cloud-messaging/concept-options) 

#### Notification message

**Send a basic notification:**

```
$optionBuiler = new OptionsBuilder();
$optionBuiler->setTimeToLive(60*20);
$option = $optionBuiler->build();

$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');
				   
$notification = $notificationBuilder->build();
				   
$response = FCM::sendTo($token, $option, $notification);

$tokensToDelete = $response->tokenToDelete();
$tokensToModify = $response->tokenToModify();

```

**Send a basic data message**

```
$dataBuilder = new PayloadDataBuilder();
$dataBuilder->addData(['a_data' => 'my_data']);
				   
$data = $dataBuilder->build();
				   
$response = FCM::sendTo($token, null, null, $data);

$tokensToDelete = $response->tokenToDelete();
$tokensToModify = $response->tokenToModify();

```

**Send a basic message with notification and data**

```
$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');	
$notification = $notificationBuilder->build();

$dataBuilder = new PayloadDataBuilder();
$dataBuilder->addData(['a_data' => 'my_data']);
$data = $dataBuilder->build();
				   
$response = FCM::sendTo($token, null, $notification, $data);

$tokensToDelete = $response->tokenToDelete();
$tokensToModify = $response->tokenToModify();

```

## Options

Laravel-FCM support options based on the options of Firebase cloud messaging. This options can help you to define the specificity of your notification.

Construct an option

```
// example
$optionsBuilder = new OptionsBuilder();
$optionsBuilder->setTimeToLive(42*60)
                ->setCollapseKey('a_collapse_key');

$options = $optionsBuilder->build();
```

#### API

**setCollapseKey( (String) $colapseKey )**

Identify a group of message that can be collapsed. In this way only the last message send with this key is showed to the user.

*Note: A maximum of 4 different collapse keys is allowed at any given time.*

--

**setTimeToLive( (int) $timeToLiveInSec )**

It specify how long (in second) the message must be keep by FCM if the device is offline

*Note: Maximum time : 2419200 (4 weeks)*

--

**setPriority( (String) $priority )**

Specify a priority for the message

value possible :

- **high** - When a message is sent with high priority, it is sent immediately, and the app can wake a sleeping device and open a network connection to your server.

- **normal** - Default mode save the battery. The device receive the message with unspecified delay.

--

**setContentAvailable( (boolean) $isAvaible )**

Specify a priority for the message

An inactive client app is awoken.

--

**setDelayWhileIdle( (boolean) $isDelayWhileIdle )**

When this parameter is set to true, it indicates that the message should not be sent until the device becomes active.

default : false

--

**setDryRun( (boolean) $isDryRun )**

This parameter, when set to true, allows developers to test a request without actually sending a message.

--

**setRestrictedPackageName( (boolean) $isRestricted )**

This parameter specifies the package name of the application where the registration tokens must match in order to receive the message.

--

You can find more information on the [official documentations](https://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json)

## Notification

Notification payload is used to send a notification, the behavior is defined by the App State and the OS of the receipt device.

**About notification message**

**Notification messages are delivered to the notification tray when the app is in the background.** For apps in the foreground, messages are handled by these callbacks: ([source](https://firebase.google.com/docs/cloud-messaging/concept-options#notifications))

- didReceiveRemoteNotification: on iOS
- onMessageReceived() on Android. The notification key in the data bundle contains the notification.

Construct a notification

```
$notificationBuilder = new PayloadNotificationBuilder();
$notificationBuilder->setTitle('title')
            		->setBody('body')
            		->setSound('sound')
            		->setBadge('badge');

$notification = $notificationBuilder->build();
```

### API

**setTitle( (String) $title )**

> Android / iOS (only watch)

Specify the notification title

--

**setBody( (String) $body )**

> Android / iOS

Specify the body of the notification

--

**setSound( (String) $resourceName )**

> Android / iOS

Indicates a sound to play when the device receives a notification. Sound files can be in the main bundle of the client app or in the Library/Sounds folder of the app's data container.

--

**setClickAction( (String) $clickAction )**

> Android / iOS

Indicates the action associated with a user click on the notification. When this is set, an activity with a matching intent filter is launched when user clicks the notification.

--

**setBody( (String) $clickAction )**

> Android / iOS

Indicates the action associated with a user click on the notification. When this is set, an activity with a matching intent filter is launched when user clicks the notification.

--

**setBodyLocationKey( (String) $bodyKey )**

> Android / iOS

Indicates the key to the body string for localization. Use the key in the app's string resources when populating this value.

--

**setBodyLocationArgs( (JSON array as string) $bodyLocArgs )**

> Android / iOS

Indicates the string value to replace format specifiers in the body string for localization. For more information

--

**setTitleLocationKey( (String) $titleKey )**

> Android / iOS

Indicates the key to the title string for localization. Use the key in the app's string resources when populating this value.

--

**setTitleLocationArgs( (JSON array as string) $titleArgs )**

> Android / iOS

Indicates the string value to replace format specifiers in the title string for localization. For more information

--

**setIcon( (String) $titleArgs )**

> Android

Indicates notification icon. Sets value to myicon for drawable resource myicon.

--

**setTag( (String) $titleArgs )**

> Android

Indicates whether each notification results in a new entry in the notification drawer on Android. 
If not set, each request creates a new notification. 
If set, and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.

--

**setColor( (String) $color )**

> Android

Indicates color of the icon, expressed in #rrggbb format

--

**setBadge( (String) $badge )**

> iOS

Indicates the badge on the client app home icon.

--

You can find more information on the [official documentations](https://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json)

## Data

DataPayload is use to send data message.

**About data message**

Set the data key with your custom key-value pairs to send a data payload to the client app. Data messages can have a 4KB maximum payload. ([source](https://firebase.google.com/docs/cloud-messaging/concept-options#data_messages))

- **iOS**, FCM stores the message and delivers it **only when the app is in the foreground** and has established a FCM connection.
- **Android**, a client app receives a data message in onMessageReceived() and can handle the key-value pairs accordingly.


Construct a data

```
$dataBuilder = new PayloadDataBuilder();
$dataBuilder->addData([
	'data_1' => 'first_data'
]);

$data = $dataBuilder->build();
```

**addData( (Array) $data )**

Add a data key and value to the payload

--

**setData( (Array) $data )**

Override with new value data key value entry

--

You can find more information on the [official documentations](https://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json)

## Notification & Data

**About both message**

App behavior when receiving messages that include both notification and data payloads depends on whether the app is in the background or the foreground—essentially, whether or not it is active at the time of receipt. ([source](https://firebase.google.com/docs/cloud-messaging/concept-options#messages-with-both-notification-and-data-payloads))

- **Background**, apps receive the notification payload in the notification tray, and only handle the data payload when the user taps on the notification.
- **Foreground**, your app receives a message object with both payloads available.

## FCMDownstream


**sendTo( (Array|String) $token, (Options) $options, (Notification) $notification, (Data) $data )**

Send a message to one or more devices and return a response

--

**sendToGroup( (String) $notificationKey, (Options) $options, (Notification) $notification, (Data) $data )**

Send a message to a group of devices and return a response

## Resonse

Response is a object created with the reponse in Json give by FCM.

The response contains information about token validity and sending state.

If your application want to process more of different case of error, you may catching Followed Exceptions

- NotGivenRecipientException
- InvalidPackageException
- InvalidNotificationException
- InvalidSenderIdException
- MessageToBigException
- InvalidDataKeyException
- InvalidTTLException

**numberSuccess()**

Return the number of success

--

**numberFailure()**

Return the number of failure

--

**numberModifiedToken()**

Return the number of token modified

--

**tokenToDelete()**

Return an array of token that are invalid and that should be removed from your datbase.

--

**tokenToModify()**

Return an array of token that are invalid and that must be remplaced by a new one in your database. Key of the array is old token and value is the new one.

--


**tokenToRetry()**

Return a two dimensional array with 3 possible causes of errors

- Unavailable => list of tokens for unavailable devices.
- InternalServerError => list of token for tokens which were thrown an error in fcm.
- DeviceMessageRateExceeded => list of tokens which have sent too many messages.

the array returned is composed likes this:

```
[
    "Unavailable" => []
    "InternalServerError" => []
    "DeviceMessageRateExceeded" => []
 ]
```

> Note: Be careful with retry, to many attempts can be caused a banishment

--

**failedRegistrationIds()**

>Is returned only with sendToGroup

return a array of token that can't be contacted in the group

### FCMGroup

**createGroup( (String) $notificationKeyName, (Array) $registrationIds )**

Create a group with a name given in notificationKeyName and a list of token (devices in the group) and return a notificationKey

--

**addToGroup((String) $notificationKeyName, (String) $notificationKey, (Array) $registrationIds )**

Add devices to an existing group and return a notificationKey

--

**removeFromGroup((String) $notificationKeyName, (String) $notificationKey, (Array) $registrationIds )**

Remove Devices from an existing group and return a notificationKey

## Liscence

MIT

Some of this documentation is coming from the official documentation. You can find it completly on the firebase cloud messagin website.
