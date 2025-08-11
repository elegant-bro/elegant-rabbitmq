<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeDeclare implements BrokerRemoteFunction
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
        $this->name = $name;
        $this->type = $type;
        $this->passive = $passive;
        $this->durable = $durable;
        $this->autoDelete = $autoDelete;
    }

    public function call(AMQPChannel $ch): void
    {
        $ch->exchange_declare(
            $this->name,
            $this->type,
            $this->passive,
            $this->durable,
            $this->autoDelete,
        );
    }
}
