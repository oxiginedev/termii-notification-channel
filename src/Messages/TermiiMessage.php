<?php

declare(strict_types=1);

namespace Adedaramola\TermiiNotificationChannel\Messages;

use Adedaramola\TermiiNotificationChannel\Enums\Type;

abstract class TermiiMessage
{
    /**
     * The content of the message
     *
     * @var string
     */
    public $content;

    /**
     * The type of the message
     *
     * @var Type
     */
    public $type = Type::PLAIN;

    /**
     * Set the content of the message
     *
     * @return $this
     */
    final public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the type of the message
     *
     * @return $this
     */
    final public function type(Type $type)
    {
        $this->type = $type;

        return $this;
    }
}
