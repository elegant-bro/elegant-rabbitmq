<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker\Queue;

use ElegantBro\RabbitMQ\V2\Broker\BrokerFunction;
use ElegantBro\RabbitMQ\V2\Broker\ChainOfCalls;
use ElegantBro\RabbitMQ\V2\Broker\ExchangeDeclare;
use ElegantBro\RabbitMQ\V2\Broker\QueueBind;
use ElegantBro\RabbitMQ\V2\Broker\QueueDeclare;
use ElegantBro\RabbitMQ\V2\DurableExchange;
use ElegantBro\RabbitMQ\V2\DurableQueue;
use ElegantBro\RabbitMQ\V2\Exchange;
use ElegantBro\RabbitMQ\V2\JustExchange;
use ElegantBro\RabbitMQ\V2\JustQueue;
use ElegantBro\RabbitMQ\V2\NoAutodeleteExchange;
use ElegantBro\RabbitMQ\V2\NoAutodeleteQueue;
use ElegantBro\RabbitMQ\V2\Queue;
use ElegantBro\RabbitMQ\V2\WithArgumentsQueue;

final class DLXRetryTopology
{
    private Exchange $exchange;

    private string $inSuffix;

    private string $outSuffix;

    private string $queueSuffix;

    private int $ttl;

    public function __construct(
        Exchange $exchange,
        string $inSuffix,
        string $outSuffix,
        string $queueSuffix,
        int $ttl
    ) {
        $this->exchange = $exchange;
        $this->inSuffix = $inSuffix;
        $this->outSuffix = $outSuffix;
        $this->queueSuffix = $queueSuffix;
        $this->ttl = $ttl;
    }

    public function composition(): BrokerFunction
    {
        $exchangeName = $this->exchange->asArray()['name'];

        return
            new ChainOfCalls(
                new ExchangeDeclare(
                    new NoAutodeleteExchange(
                        new DurableExchange(
                            JustExchange::default($outExchange = $exchangeName . $this->outSuffix, 'direct'),
                        ),
                    ),
                ),
                new ExchangeDeclare(
                    new NoAutodeleteExchange(
                        new DurableExchange(
                            JustExchange::default($inExchange = $exchangeName . $this->inSuffix, 'fanout'),
                        ),
                    ),
                ),
                new QueueDeclare(
                    new WithArgumentsQueue(
                        [
                            'x-dead-letter-exchange' => $outExchange,
                            'x-message-ttl' => $this->ttl,
                        ],
                        new NoAutodeleteQueue(
                            new DurableQueue(
                                JustQueue::default($queueRetry = $exchangeName . $this->queueSuffix),
                            ),
                        ),
                    ),
                ),
                new QueueBind(
                    $queueRetry,
                    $inExchange,
                    '',
                ),
            );
    }

    public function addQueue(Queue $queue): Queue
    {
        return new WithArgumentsQueue(
            [
                'x-dead-letter-exchange' => $this->exchange->asArray()['name'] . $this->inSuffix,
                'x-dead-letter-routing-key' => $queue->asArray()['name'],
            ],
            $queue,
        );
    }
}
