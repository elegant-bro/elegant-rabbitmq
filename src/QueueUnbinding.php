<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final readonly class QueueUnbinding
{
    public function __construct(
        private string $name,
        private string $exchange,
        private string $key,
        private null|AMQPTable|array $args = null,
    ) {}

    public function unbind(AMQPChannel $ch): void
    {
        $ch->queue_unbind(
            $this->name,
            $this->exchange,
            $this->key,
            $this->args ?? [],
        );
    }
}
