<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeDelete implements BrokerRemoteFunction
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
