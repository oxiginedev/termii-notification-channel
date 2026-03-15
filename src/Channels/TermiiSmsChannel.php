<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Channels;

use Adedaramola\TermiiNotificationChannel\Contracts\TermiiSmsNotification;
use Adedaramola\TermiiNotificationChannel\Enums\Channel;
use Adedaramola\TermiiNotificationChannel\Termii;
use Illuminate\Notifications\Notification;
use RuntimeException;

final readonly class TermiiSmsChannel
{
    public function __construct(private Termii $termii) {}

    public function send(object $notifiable, Notification&TermiiSmsNotification $notification): array
    {
        if (! $to = $notifiable->routeNotificationFor('termiiSms', $notification)) {
            throw new RuntimeException(
                'The routeNotificationForTermiiSms method is missing on notifiable instance',
            );
        }

        $message = $notification->toTermiiSms($notifiable);
        $channel = $message->useDnd ? Channel::DND : Channel::GENERIC;

        return $this->termii->sendSms($to, $message->content, $message->type, $channel);
    }
}
