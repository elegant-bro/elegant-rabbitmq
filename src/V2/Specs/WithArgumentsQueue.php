<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Specs;

use PhpAmqpLib\Wire\AMQPTable;

final class WithArgumentsQueue implements Queue
{
    private AMQPTable $args;

    private Queue $original;

    public function __construct(
        AMQPTable $args,
        Queue $original
    ) {
        $this->args = $args;
        $this->original = $original;
    }

    public function asArray(): array
    {
        $q = $this->original->asArray();
        $q['args'] = $this->args;
        return $q;
    }
}
