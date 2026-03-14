<?php

declare(strict_types=1);

namespace Oxiginedev\Termii\Data;

use Illuminate\Contracts\Support\Arrayable;

final readonly class Media implements Arrayable
{
    public function __construct(
        public ?string $url,
        public ?string $caption,
    ) {}

    public function toArray()
    {
        return [
            'url' => $this->url,
            'caption' => $this->caption,
        ];
    }
}
