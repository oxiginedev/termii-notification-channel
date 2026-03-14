<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Messages;

use Oxiginedev\Termii\Data\Media;

final class TermiiWhatsappMessage extends TermiiMessage
{
    /**
     * The media attached to the message
     *
     * @var Media
     */
    public $media;

    /**
     * Set the media for the message
     *
     * @return $this
     */
    public function media(Media $media): self
    {
        $this->media = $media;

        return $this;
    }
}
