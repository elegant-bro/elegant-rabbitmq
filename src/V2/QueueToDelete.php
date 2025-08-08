<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Channel\AMQPChannel;

final class QueueToDelete implements RabbitRPC
{
    private string $queue;

    public function __construct(string $queue)
    {
        $this->queue = $queue;
    }

    public function call(AMQPChannel $ch): void
    {
        $ch->queue_delete($this->queue);
    }
}
