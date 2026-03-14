<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Channels;

use Illuminate\Notifications\Notification;
use Oxiginedev\Termii\Contracts\TermiiSmsNotification;
use Oxiginedev\Termii\Enums\Channel;
use Oxiginedev\Termii\Termii;
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
