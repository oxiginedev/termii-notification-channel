<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Messages;

final class TermiiWhatsappMessage extends TermiiMessage
{
    /**
     * The url of the media attached to the message
     *
     * @var string
     */
    public $mediaUrl;

    /**
     * The caption for the media
     *
     * @var string
     */
    public $mediaCaption;

    /**
     * Set the media url for the message
     *
     * @return $this
     */
    public function mediaUrl(string $url): self
    {
        $this->mediaUrl = $url;

        return $this;
    }

    /**
     * Set the media caption for the message
     *
     * @return $this
     */
    public function mediaCaption(string $caption): self
    {
        $this->mediaCaption = $caption;

        return $this;
    }
}
