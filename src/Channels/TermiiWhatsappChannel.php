<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Channels;

use Adedaramola\TermiiNotificationChannel\Contracts\TermiiWhatsappNotification;
use Adedaramola\TermiiNotificationChannel\Termii;
use Illuminate\Notifications\Notification;
use RuntimeException;

final readonly class TermiiWhatsappChannel
{
    public function __construct(private Termii $termii) {}

    public function send(object $notifiable, Notification&TermiiWhatsappNotification $notification): array
    {
        if (! $to = $notifiable->routeNotificationFor('termiiWhatsapp', $notification)) {
            throw new RuntimeException(
                'The routeNotificationForTermiiWhatsapp method is missing on notifiable instance',
            );
        }

        $message = $notification->toTermiiWhatsapp($notifiable);

        return $this->termii->sendWhatsapp(
            $to,
            $message->content,
            $message->type,
            $message->mediaUrl,
            $message->mediaCaption
        );
    }
}
