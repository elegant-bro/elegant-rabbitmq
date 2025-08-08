<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class UnbindFromQueue implements RabbitRPC
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
        string $name,
        string $exchange,
        string $key,
        $args
    ) {
        $this->args = $args;
        $this->key = $key;
        $this->exchange = $exchange;
        $this->name = $name;
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
