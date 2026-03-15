# Laravel Termii Notification Channel

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [SMS Channel](#sms-channel)
- [Whatsapp Channel](#whatsapp-channel)
- [License](#license)

## Installation

```bash
composer require adedaramola/termii-notification-channel
```

## Configuration

Ensure you add the following key to your environment file

```env
TERMII_URL=
TERMII_API_KEY=
TERMII_SENDER_ID=
```

## SMS Channel


### Routing SMS Notifications
First, you need to define where the SMS notifications needs to be routed to. Define a `routeNotificationForTermiiSms` method on your notifiable entity. Ensure the phone number is internationally formatted (i.e, 2349001111222).

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Termii sms channel.
     */
    public function routeNotificationForTermiiSms(Notification $notification): string
    {
        return $this->phone_number;
    }
}
```

### Formatting SMS Notifications

If a notification should be sent using Termii SMS, the notification class must first implement the `Adedaramola\TermiiNotificationChannel\Contracts\TermiSmsNotification` interface, this requires you to define a `toTermiiSms` method on the notification entity

```php
<?php

namespace App\Notifications;

use Adedaramola\TermiiNotificationChannel\Channels\TermiiSmsChannel;
use Adedaramola\TermiiNotificationChannel\Contracts\TermiiSmsNotification;
use Adedaramola\TermiiNotificationChannel\Messages\TermiiSmsMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements TermiiSmsNotification
{
    public function via(object $notifiable): array
    {
        return [TermiiSmsChannel::class];
    }

    public function toTermiiSms(object $notifiable): TermiiSmsMessage
    {
        return (new TermiiSmsMessage)
            ->content('This is a test notification');
    }
}
```

### Sending SMS using DND channel

By default, all sms messages will be sent using the `generic` channel. This behaviour can be customised by calling

```php
Termii::useDefaultSmsChannel(Channel::DND);
```

This should ideally be called the the `boot` method of your `AppServiceProvider`. Alternatively, you can also call the `useDnd` method on the message class.

```php
use Adedaramola\TermiiNotificationChannel\Messages\TermiiSmsMessage;

public function toTermiiSms(object $notifiable): TermiiSmsMessage
{
    return (new TermiiSmsMessage)
        ->content('This should be sent through the dnd channel')
        ->useDnd();
}
```

### Customizing the SMS message type

You can specify the format of the message being sent. Supported types includes, `plain`, `unicode`, `voice`.

```php
use Adedaramola\TermiiNotificationChannel\Enums\Type;
use Adedaramola\TermiiNotificationChannel\Messages\TermiiSmsMessage;

public function toTermiiSms(object $notifiable): TermiiSmsMessage
{
    return (new TermiiSmsMessage)
        ->content('This should be sent using another type')
        ->type(Type::UNICODE);
}
```

## Whatsapp Channel

Termii also supports sending messages to whatsapp.

### Routing Whatsapp Notifications

You also need to define where the whatsapp notifications needs to be routed to. Define a `routeNotificationForTermiiWhatsapp` method on your notifiable entity. Ensure the phone number is internationally formatted (i.e, 2349001111222).

### Sending Whatsapp Notifications

If a notification should be sent using Termii Whatsapp, the notification class must first implement the `Adedaramola\TermiiNotificationChannel\Contracts\TermiWhatsappNotification` interface, this requires you to define a `toTermiiWhatsapp` method on the notification entity

```php
<?php

namespace App\Notifications;

use Adedaramola\TermiiNotificationChannel\Channels\TermiiWhatsappChannel;
use Adedaramola\TermiiNotificationChannel\Contracts\TermiiWhatsappNotification;
use Adedaramola\TermiiNotificationChannel\Messages\TermiiWhatsappMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements TermiiWhatsappNotification
{
    public function via(object $notifiable): array
    {
        return [TermiiWhatsappChannel::class];
    }

    public function toTermiiWhatsapp(object $notifiable): TermiiWhatsappMessage
    {
        return (new TermiiWhatsappMessage)
            ->content('This is a test notification')
            ->mediaUrl('https://link.to/media')
            ->mediaCaption('This is a sample media');
    }
}
```

## License

Termii Notification Channel is open-sourced software licensed under the [MIT license](LICENSE.md).