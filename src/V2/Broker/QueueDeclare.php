<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use ElegantBro\RabbitMQ\V2\JustQueue;
use ElegantBro\RabbitMQ\V2\Queue;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueDeclare implements BrokerFunction
{
    private Queue $q;

    /**
     * @param array<string, mixed>|null $args
     */
    public static function fromPrimitives(
        string $name,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete,
        bool $nowait,
        ?array $args = null
    ): self {
        return new self(
            new JustQueue(
                $name,
                $passive,
                $durable,
                $exclusive,
                $autoDelete,
                $nowait,
                $args,
            ),
        );
    }

    public function __construct(Queue $q)
    {
        $this->q = $q;
    }

    public function call(AMQPChannel $ch): void
    {
        $input = $this->q->asArray();

        $ch->queue_declare(
            $input['name'],
            $input['passive'],
            $input['durable'],
            $input['exclusive'],
            $input['auto_delete'],
            $input['nowait'],
            null !== $input['args'] ? new AMQPTable($input['args']) : [],
        );
    }
}
