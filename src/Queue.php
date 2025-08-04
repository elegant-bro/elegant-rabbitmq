<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final readonly class Queue
{
    public function __construct(
        private string $name,
        private bool $passive,
        private bool $durable,
        private bool $exclusive,
        private bool $autoDelete,
        private bool $noWait,
        private null|AMQPTable|array $args,
    ) {}

    public function declare(AMQPChannel $ch): void
    {
        $ch->queue_declare(
            $this->name,
            $this->passive,
            $this->durable,
            $this->exclusive,
            $this->autoDelete,
            $this->noWait,
            $this->args ?? [],
        );
    }

    public function delete(AMQPChannel $ch): void
    {
        $ch->queue_delete($this->name);
    }
}
