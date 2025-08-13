<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueUnbind implements BrokerFunction
{
    private string $name;

    private string $exchange;

    private string $key;

    /**
     * @var null|array<string, mixed>
     */
    private ?array $args;

    /**
     * @param array<string, mixed>|null $args
     */
    public function __construct(
        string $queue,
        string $exchange,
        string $routingKey,
        ?array $args = null
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
            null !== $this->args ? new AMQPTable($this->args) : [],
        );
    }
}
