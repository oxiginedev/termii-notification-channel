<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Enums;

enum Type: string
{
    case PLAIN = 'plain';
    case UNICODE = 'unicode';
    case VOICE = 'voice';
}
