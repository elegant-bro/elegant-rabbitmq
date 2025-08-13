<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;

final class ChainOfCalls implements BrokerFunction
{
    /**
     * @var iterable<BrokerFunction>
     */
    private iterable $functions;

    public function __construct(BrokerFunction ...$functions)
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
