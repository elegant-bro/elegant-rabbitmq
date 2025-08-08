<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Channel\AMQPChannel;

final class ChainOfCalls implements RabbitRPC
{
    /**
     * @var iterable<RabbitRPC>
     */
    private iterable $actions;

    public function __construct(RabbitRPC ...$actions)
    {
        $this->actions = $actions;
    }

    public function call(AMQPChannel $ch): void
    {
        foreach ($this->actions as $action) {
            $action->call($ch);
        }
    }
}
