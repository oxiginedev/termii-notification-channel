<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Messages;

final class TermiiSmsMessage extends TermiiMessage
{
    /**
     * Route the message through the dnd channel
     *
     * @var bool
     */
    public $useDnd;

    /**
     * Set the useDnd condition
     *
     * @return $this
     */
    public function useDnd(bool|callable $condition = true, mixed ...$args): self
    {
        $this->useDnd = is_callable($condition) ? $condition($args) : $condition;

        return $this;
    }
}
