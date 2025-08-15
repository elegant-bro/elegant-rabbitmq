<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use ElegantBro\RabbitMQ\V2\Queue;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

final class QueueDeclare implements BrokerFunction
{
    private string $name;
    private bool $passive;
    private bool $durable;
    private bool $exclusive;
    private bool $autoDelete;
    private bool $nowait;
    private ?array $args;

    public static function fromQueue(Queue $q): self
    {
        $input = $q->asArray();

        return new self(
            $input['name'],
            $input['passive'],
            $input['durable'],
            $input['exclusive'],
            $input['auto_delete'],
            $input['nowait'],
            $input['args'],
        );
    }

    public function __construct(
        string $name,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete,
        bool $nowait,
        ?array $args = null
    )
    {
        $this->name = $name;
        $this->passive = $passive;
        $this->durable = $durable;
        $this->exclusive = $exclusive;
        $this->autoDelete = $autoDelete;
        $this->nowait = $nowait;
        $this->args = $args;
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
            null !== $this->args ? new AMQPTable($this->args) : [],
        );
    }
}
