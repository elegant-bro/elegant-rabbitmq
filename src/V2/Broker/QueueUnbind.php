<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueUnbind implements BrokerRemoteFunction
{
    private string $name;

    private string $exchange;

    private string $key;

    /**
     * @var null|AMQPTable|array<string, mixed>
     */
    private $args;

    /**
     * @param null|AMQPTable|array<string, mixed> $args
     */
    public function __construct(
        string $queue,
        string $exchange,
        string $routingKey,
        $args = null
    ) {
        $this->name = $queue;
        $this->exchange = $exchange;
        $this->key = $routingKey;
        $this->args = $args;
    }

    public function call(AMQPChannel $ch): void
    {
        $ch->queue_unbind(
            $this->name,
            $this->exchange,
            $this->key,
            $this->args ?? [],
        );
    }
}
