<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Contracts;

use Oxiginedev\Termii\Messages\TermiiWhatsappMessage;

interface TermiiWhatsappNotification
{
    public function toTermiiWhatsapp(object $notifiable): TermiiWhatsappMessage;
}
