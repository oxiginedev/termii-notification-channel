<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Enums;

enum Type: string
{
    case PLAIN = 'plain';
    case UNICODE = 'unicode';
    case VOICE = 'voice';
}
