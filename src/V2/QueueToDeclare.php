<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueToDeclare implements RabbitRPC
{
    private string $name;

    private bool $passive;

    private bool $durable;

    private bool $exclusive;

    private bool $autoDelete;

    private bool $nowait;

    /**
     * @var null|AMQPTable|array<string, mixed>
     */
    private $args;

    /**
     * @param null|AMQPTable|array<string, mixed> $args
     */
    public function __construct(
        string $name,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete,
        bool $nowait,
        $args
    ) {
        $this->args = $args;
        $this->nowait = $nowait;
        $this->autoDelete = $autoDelete;
        $this->exclusive = $exclusive;
        $this->durable = $durable;
        $this->passive = $passive;
        $this->name = $name;
    }

    public function call(AMQPChannel $ch): void
    {
        $ch->queue_declare(
            $this->name,
            $this->passive,
            $this->durable,
            $this->exclusive,
            $this->autoDelete,
            $this->nowait,
            $this->args ?? [],
        );
    }
}
