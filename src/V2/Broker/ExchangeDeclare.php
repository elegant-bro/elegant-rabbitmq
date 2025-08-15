<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use ElegantBro\RabbitMQ\V2\Exchange;
use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeDeclare implements BrokerFunction
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

    public static function fromExchange(Exchange $exchange): self
    {
        $args = $exchange->asArray();
        return new self(
            $args['name'],
            $args['type'],
            $args['passive'],
            $args['durable'],
            $args['auto_delete'],
        );
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
