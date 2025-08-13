<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker\Queue;

use Closure;
use ElegantBro\RabbitMQ\V2\Broker\BindPair;
use ElegantBro\RabbitMQ\V2\Broker\BrokerFunction;
use ElegantBro\RabbitMQ\V2\Broker\ChainOfCalls;
use ElegantBro\RabbitMQ\V2\Broker\QueueDelete;
use ElegantBro\RabbitMQ\V2\Queue;
use ElegantBro\RabbitMQ\V2\ResolvedQueue;
use function array_map;

final class DeclaredQueue
{
    private Queue $specs;

    public function __construct(
        Queue $specs
    ) {
        $this->specs = new ResolvedQueue($specs);
    }

    /**
     * @param Closure(Queue $specs): BrokerFunction $declareFn
     */
    public function __invoke(Closure $declareFn): BrokerFunction
    {
        return $declareFn($this->specs);
    }

    public function bind(BindPair ...$pairs): BrokerFunction
    {
        return new ChainOfCalls(
            ...array_map(
                fn(BindPair $p): BrokerFunction => $p->bind($this->specs->asArray()['name']),
                $pairs,
            ),
        );
    }

    public function unbind(BindPair ...$pairs): BrokerFunction
    {
        return new ChainOfCalls(
            ...array_map(
                fn(BindPair $p): BrokerFunction => $p->unbind($this->specs->asArray()['name']),
                $pairs,
            ),
        );
    }

    public function delete(): BrokerFunction
    {
        return new QueueDelete($this->specs->asArray()['name']);
    }
}
