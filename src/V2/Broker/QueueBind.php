<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueBind implements BrokerRemoteFunction
{
    private string $queue;

    private string $exchange;

    private string $routingKey;

    private bool $nowait;

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
        bool $nowait,
        $args = null
    ) {
        $this->queue = $queue;
        $this->exchange = $exchange;
        $this->routingKey = $routingKey;
        $this->nowait = $nowait;
        $this->args = $args;
    }

    public function call(AMQPChannel $ch): void
    {
        $ch->queue_bind(
            $this->queue,
            $this->exchange,
            $this->routingKey,
            $this->nowait,
            $this->args ?? [],
        );
    }
}
