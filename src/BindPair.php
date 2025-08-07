<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

final class BindPair
{
    private string $exchange;

    private string $key;

    public function __construct(
        string $exchange,
        string $key
    ) {
        $this->exchange = $exchange;
        $this->key = $key;
    }

    public function exchange(): string
    {
        return $this->exchange;
    }

    public function key(): string
    {
        return $this->key;
    }
}
