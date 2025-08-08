<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Composition;

use ElegantBro\RabbitMQ\V2\Specs\DurableQueue;
use ElegantBro\RabbitMQ\V2\Specs\JustQueue;
use ElegantBro\RabbitMQ\V2\Specs\NoAutoDeleteQueue;
use ElegantBro\RabbitMQ\V2\Specs\Queue;
use ElegantBro\RabbitMQ\V2\Specs\WithArgumentsQueue;
use PhpAmqpLib\Wire\AMQPTable;

final class NoAutoDeleteDurableQueue implements Queue
{
    private Queue $q;

    public static function newWithNoArguments(string $name): self
    {
        return new self($name, new AMQPTable([]));
    }

    public function __construct(string $name, AMQPTable $args)
    {
        $this->q =
            new WithArgumentsQueue(
                $args,
                new DurableQueue(
                    new NoAutoDeleteQueue(
                        JustQueue::default($name),
                    ),
                ),
            );
    }

    public function asArray(): array
    {
        return $this->q->asArray();
    }
}
