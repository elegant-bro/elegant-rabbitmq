<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use ElegantBro\RabbitMQ\V2\Exchange;
use ElegantBro\RabbitMQ\V2\JustExchange;
use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeDeclare implements BrokerFunction
{
    private Exchange $specs;

    public static function fromPrimitives(
        string $name,
        string $type,
        bool $passive,
        bool $durable,
        bool $autoDelete
    ): self {
        return new self(
            new JustExchange(
                $name,
                $type,
                $passive,
                $durable,
                $autoDelete,
            ),
        );
    }

    public function __construct(Exchange $specs)
    {
        $this->specs = $specs;
    }

    public function call(AMQPChannel $ch): void
    {
        $args = $this->specs->asArray();
        $ch->exchange_declare(
            $args['name'],
            $args['type'],
            $args['passive'],
            $args['durable'],
            $args['auto_delete'],
        );
    }
}
