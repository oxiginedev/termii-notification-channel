<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Enums;

enum Channel: string
{
    case DND = 'dnd';
    case GENERIC = 'generic';
    case WHATSAPP = 'whatsapp';
    case VOICE = 'voice';
}
