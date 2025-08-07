<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;

final class Exchange
{
    private string $name;

    private string $type;

    private bool $passive;

    private bool $durable;

    private bool $autoDelete;

    public function __construct(
        string $name,
        string $type,
        bool $passive,
        bool $durable,
        bool $autoDelete
    ) {
        $this->autoDelete = $autoDelete;
        $this->durable = $durable;
        $this->passive = $passive;
        $this->type = $type;
        $this->name = $name;
    }

    public function declare(AMQPChannel $ch): void
    {
        $ch->exchange_declare(
            $this->name,
            $this->type,
            $this->passive,
            $this->durable,
            $this->autoDelete,
        );
    }

    public function delete(AMQPChannel $ch): void
    {
        $ch->exchange_delete($this->name);
    }
}
