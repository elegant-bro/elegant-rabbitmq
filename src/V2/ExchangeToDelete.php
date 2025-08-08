<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeToDelete implements RabbitRPC
{
    private string $queue;

    public function __construct(string $queue)
    {
        $this->queue = $queue;
    }

    public function call(AMQPChannel $ch): void
    {
        $ch->exchange_delete($this->queue);
    }
}
