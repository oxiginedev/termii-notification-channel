<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Channels;

use Illuminate\Notifications\Notification;
use Oxiginedev\Termii\Contracts\TermiiWhatsappNotification;
use Oxiginedev\Termii\Termii;
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

        return $this->termii->sendWhatsapp($to, $message->content, $message->media);
    }
}
