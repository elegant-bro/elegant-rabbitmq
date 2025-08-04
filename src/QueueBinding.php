<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final readonly class QueueBinding
{
    public function __construct(
        private string $name,
        private string $exchange,
        private string $key,
        private bool $nowait,
        private null|AMQPTable|array $args = null,
    ) {}

    public function bind(AMQPChannel $ch): void
    {
        $ch->queue_bind(
            $this->name,
            $this->exchange,
            $this->key,
            $this->nowait,
            $this->args ?? [],
        );
    }
}
