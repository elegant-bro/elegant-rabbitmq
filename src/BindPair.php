<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

final readonly class BindPair
{
    public function __construct(
        private string $exchange,
        private string $key,
    ) {}

    public function exchange(): string
    {
        return $this->exchange;
    }

    public function key(): string
    {
        return $this->key;
    }
}
