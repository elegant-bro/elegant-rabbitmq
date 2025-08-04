<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueBinding
{
    private string $name;

    private string $exchange;

    private string $key;

    private bool $nowait;

    /**
     * @var null|AMQPTable|array
     */
    private $args;

    public function __construct(
        string $name,
        string $exchange,
        string $key,
        bool $nowait,
        $args
    ) {
        $this->args = $args;
        $this->nowait = $nowait;
        $this->key = $key;
        $this->exchange = $exchange;
        $this->name = $name;
    }

    public function bind(AMQPChannel $ch): void
    {
        $ch->queue_bind(
            $this->name,
            $this->exchange,
            $this->key,
            $this->nowait,
            $this->args ?? [],
        );
    }
}
