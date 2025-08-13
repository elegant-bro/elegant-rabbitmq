<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

final class BindPair
{
    private string $exchange;

    private string $routingKey;

    private bool $nowait;

    /**
     * @var null|array<string, mixed>
     */
    private ?array $args;

    /**
     * @param null|array<string, mixed> $args
     */
    public function __construct(
        string $exchange,
        string $routingKey,
        bool $nowait = false,
        ?array $args = null
    ) {
        $this->exchange = $exchange;
        $this->routingKey = $routingKey;
        $this->nowait = $nowait;
        $this->args = $args;
    }

    public function bind(string $queue): BrokerFunction
    {
        return new QueueBind($queue, $this->exchange, $this->routingKey, $this->nowait, $this->args);
    }

    public function unbind(string $queue): BrokerFunction
    {
        return new QueueUnbind($queue, $this->exchange, $this->routingKey, $this->args);
    }
}
