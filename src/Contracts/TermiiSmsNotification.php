<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Contracts;

use Adedaramola\TermiiNotificationChannel\Messages\TermiiSmsMessage;

interface TermiiSmsNotification
{
    public function toTermiiSms(object $notifiable): TermiiSmsMessage;
}
