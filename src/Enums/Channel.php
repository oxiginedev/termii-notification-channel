<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Enums;

enum Channel: string
{
    case DND = 'dnd';
    case GENERIC = 'generic';
    case WHATSAPP = 'whatsapp';
    case VOICE = 'voice';

    /**
     * Get the default SMS channels
     *
     * @return Channel[]
     */
    public static function defaultSmsChannels(): array
    {
        return [self::DND, self::GENERIC];
    }
}
