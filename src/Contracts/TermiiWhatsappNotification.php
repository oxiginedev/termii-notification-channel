<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Contracts;

use Adedaramola\TermiiNotificationChannel\Messages\TermiiWhatsappMessage;

interface TermiiWhatsappNotification
{
    public function toTermiiWhatsapp(object $notifiable): TermiiWhatsappMessage;
}
