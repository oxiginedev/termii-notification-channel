<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Contracts;

use Oxiginedev\Termii\Messages\TermiiSmsMessage;

interface TermiiSmsNotification
{
    public function toTermiiSms(object $notifiable): TermiiSmsMessage;
}
