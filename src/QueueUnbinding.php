<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueUnbinding
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
