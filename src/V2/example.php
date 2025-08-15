<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use ElegantBro\RabbitMQ\V2\Broker\BrokerFunction;
use ElegantBro\RabbitMQ\V2\Broker\ChainOfCalls;
use ElegantBro\RabbitMQ\V2\Broker\ExchangeDeclare;
use ElegantBro\RabbitMQ\V2\Broker\Queue\BindPair;
use ElegantBro\RabbitMQ\V2\Broker\Queue\DeclaredQueue;
use ElegantBro\RabbitMQ\V2\Broker\Queue\DLXRetryTopology;
use ElegantBro\RabbitMQ\V2\Broker\QueueDeclare;
use PhpAmqpLib\Channel\AMQPChannel;

function example(AMQPChannel $ch): void
{
    (new ChainOfCalls(
        ExchangeDeclare::fromExchange(
            new NoAutodeleteExchange(
                new DurableExchange(
                    JustExchange::default('test_exchange', 'direct'),
                ),
            ),
        ),
        ($q = new DeclaredQueue(
            new WithArgumentsQueue(
                [],
                new DurableQueue(
                    new NoAutodeleteQueue(
                        JustQueue::default('test_queue'),
                    ),
                ),
            ),
        ))(
            static fn(Queue $specs): BrokerFunction => QueueDeclare::fromQueue($specs),
        ),
        $q->bind(
            new BindPair('test_exchange', 'test_routing_key_1'),
        ),
        $q->unbind(
            new BindPair('test_exchange', 'test_routing_key_2'),
        ),
    ))->call($ch);
}

function example_2(AMQPChannel $ch): void
{
    (new ChainOfCalls(
        ExchangeDeclare::fromExchange(
            $exchange = new NoAutodeleteExchange(
                new DurableExchange(
                    JustExchange::default('test_exchange', 'direct'),
                ),
            ),
        ),
        ($topology = DLXRetryTopology::fromExchange(
            $exchange,
            '_in_dlx',
            '_out_dlx',
            '.q_dlx',
            3000,
        ))->composition(),
        ($q = new DeclaredQueue(
            $topology->addQueue(
                new DurableQueue(
                    new NoAutodeleteQueue(
                        JustQueue::default('test_queue'),
                    ),
                ),
            ),
        ))(
            static fn(Queue $specs): BrokerFunction => QueueDeclare::fromQueue($specs),
        ),
        $q->bind(
            new BindPair('test_exchange', 'test_routing_key_1'),
        ),
    ))->call($ch);
}
