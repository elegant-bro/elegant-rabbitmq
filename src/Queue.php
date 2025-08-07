<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class Queue
{
    private string $name;

    private bool $passive;

    private bool $durable;

    private bool $exclusive;

    private bool $autoDelete;

    private bool $noWait;

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
        bool $noWait,
        $args
    ) {
        $this->args = $args;
        $this->noWait = $noWait;
        $this->autoDelete = $autoDelete;
        $this->exclusive = $exclusive;
        $this->durable = $durable;
        $this->passive = $passive;
        $this->name = $name;
    }

    public function declare(AMQPChannel $ch): void
    {
        $ch->queue_declare(
            $this->name,
            $this->passive,
            $this->durable,
            $this->exclusive,
            $this->autoDelete,
            $this->noWait,
            $this->args ?? [],
        );
    }

    public function delete(AMQPChannel $ch): void
    {
        $ch->queue_delete($this->name);
    }
}
