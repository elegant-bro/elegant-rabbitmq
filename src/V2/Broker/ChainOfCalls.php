<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;

final class ChainOfCalls implements BrokerRemoteFunction
{
    /**
     * @var iterable<BrokerRemoteFunction>
     */
    private iterable $functions;

    public function __construct(BrokerRemoteFunction ...$functions)
    {
        $this->functions = $functions;
    }

    public function call(AMQPChannel $ch): void
    {
        foreach ($this->functions as $f) {
            $f->call($ch);
        }
    }
}
