# Laravel Termii Notification Channel

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [SMS Channel](#sms-channel)
- [Whatsapp Channel](#whatsapp-channel)
- [License](#license)

## Installation

```bash
composer require oxiginedev/termii-notification-channel
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

If a notification should be sent using Termii SMS, the notification class must first implement the `Oxiginedev\Termii\Contracts\TermiSmsNotification` interface, this requires you to define a `toTermiiSms` method on the notification entity

```php
<?php

namespace App\Notifications;

use Oxiginedev\Termii\Channels\TermiiSmsChannel;
use Oxiginedev\Termii\Contracts\TermiiSmsNotification;
use Oxiginedev\Termii\Messages\TermiiSmsMessage;
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
use Oxiginedev\Termii\Messages\TermiiSmsMessage;

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
use Oxiginedev\Termii\Enums\Type;
use Oxiginedev\Termii\Messages\TermiiSmsMessage;

public function toTermiiSms(object $notifiable): TermiiSmsMessage
{
    return (new TermiiSmsMessage)
        ->content('This should be sent using another type')
        ->type(Type::UNICODE);
}
```

## License

Termii Notification Channel is open-sourced software licensed under the [MIT license](LICENSE.md).