<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Messages;

final class TermiiSmsMessage extends TermiiMessage
{
    public $dnd;

    /**
     * Route the message through the dnd channel
     *
     * @var bool
     */
    public $useDnd;

    /**
     * Summary of routeDnd
     *
     * @return $this
     */
    public function useDnd(bool|callable $dnd = false, ...$args): self
    {
        $this->dnd = is_callable($dnd) ? $dnd($args) : $dnd;

        return $this;
    }
}
