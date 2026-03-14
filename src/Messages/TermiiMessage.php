<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Messages;

abstract class TermiiMessage
{
    /**
     * The content of the message
     *
     * @var string
     */
    public $content;

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
}
