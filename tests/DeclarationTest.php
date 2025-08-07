<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests;

use ElegantBro\RabbitMQ\Declaration;
use ElegantBro\RabbitMQ\Tests\Support\ArrayWithConsecutive;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\exactly;

final class DeclarationTest extends TestCase
{
    public function testWithExchange(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(exactly(3))
            ->method('exchange_declare')
            ->with(
                ...(new ArrayWithConsecutive(
                    [
                        [
                            'exchange_1',
                            'topic',
                            false,
                            true,
                            false,
                        ],
                        [
                            'exchange_2',
                            'direct',
                            false,
                            true,
                            false,
                        ],
                        [
                            'exchange_3',
                            'fanout',
                            false,
                            true,
                            false,
                        ],
                    ],
                ))(),
            )
        ;

        foreach (
            Declaration::new()
                ->withExchange('exchange_1', 'topic')
                ->withExchange('exchange_2', 'direct')
                ->withExchange('exchange_3', 'fanout')
                ->finish()->exchanges() as $exchange
        ) {
            $exchange->declare($ch);
        }
    }

    public function testWithoutExchange(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(exactly(3))
            ->method('exchange_delete')
            ->with(
                ...(new ArrayWithConsecutive(
                    [
                        [
                            'exchange_1',
                        ],
                        [
                            'exchange_2',
                        ],
                        [
                            'exchange_3',
                        ],
                    ],
                ))(),
            )
        ;

        foreach (
            Declaration::new()
                ->withoutExchange('exchange_1')
                ->withoutExchange('exchange_2')
                ->withoutExchange('exchange_3')
                ->finish()->deletingExchanges() as $exchange
        ) {
            $exchange->delete($ch);
        }
    }

    public function testWithQueue(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(exactly(3))
            ->method('queue_declare')
            ->with(
                ...(new ArrayWithConsecutive(
                    [
                        [
                            'queue_1',
                            false,
                            true,
                            false,
                            false,
                            false,
                            self::callback(
                                static function (AMQPTable $t): bool {
                                    self::assertSame(
                                        ['foo' => 'bar1'],
                                        $t->getNativeData(),
                                    );
                                    return true;
                                },
                            ),
                            null,
                        ],
                        [
                            'queue_2',
                            false,
                            true,
                            false,
                            false,
                            false,
                            self::callback(
                                static function (AMQPTable $t): bool {
                                    self::assertSame(
                                        ['foo' => 'bar2'],
                                        $t->getNativeData(),
                                    );
                                    return true;
                                },
                            ),
                            null,
                        ],
                        [
                            'queue_3',
                            false,
                            true,
                            false,
                            false,
                            false,
                            self::callback(
                                static function (AMQPTable $t): bool {
                                    self::assertSame(
                                        ['foo' => 'bar3'],
                                        $t->getNativeData(),
                                    );
                                    return true;
                                },
                            ),
                            null,
                        ],
                    ],
                ))(),
            )
        ;

        foreach (
            Declaration::new()
                ->withQueue('queue_1', true, new AMQPTable(['foo' => 'bar1']))
                ->withQueue('queue_2', true, new AMQPTable(['foo' => 'bar2']))
                ->withQueue('queue_3', true, new AMQPTable(['foo' => 'bar3']))
                ->finish()->queues() as $queue
        ) {
            $queue->declare($ch);
        }
    }

    public function testWithoutQueue(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(exactly(3))
            ->method('queue_delete')
            ->with(
                ...(new ArrayWithConsecutive(
                    [
                        [
                            'queue_1',
                        ],
                        [
                            'queue_2',
                        ],
                        [
                            'queue_3',
                        ],
                    ],
                ))(),
            )
        ;

        foreach (
            Declaration::new()
                ->withoutQueue('queue_1')
                ->withoutQueue('queue_2')
                ->withoutQueue('queue_3')
                ->finish()->deletingQueues() as $queue
        ) {
            $queue->delete($ch);
        }
    }

    public function testWithBinding(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(exactly(3))
            ->method('queue_bind')
            ->with(
                ...(new ArrayWithConsecutive(
                    [
                        [
                            'queue_1',
                            'exchange_1',
                            'key_1',
                        ],
                        [
                            'queue_2',
                            'exchange_2',
                            'key_2',
                        ],
                        [
                            'queue_3',
                            'exchange_3',
                            'key_3',
                        ],
                    ],
                ))(),
            )
        ;

        foreach (
            Declaration::new()
                ->withBinding('exchange_1', 'queue_1', 'key_1')
                ->withBinding('exchange_2', 'queue_2', 'key_2')
                ->withBinding('exchange_3', 'queue_3', 'key_3')
                ->finish()->bindings() as $binding
        ) {
            $binding->bind($ch);
        }
    }

    public function testWithoutBinding(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(exactly(3))
            ->method('queue_unbind')
            ->with(
                ...(new ArrayWithConsecutive(
                    [
                        [
                            'queue_1',
                            'exchange_1',
                            'key_1',
                        ],
                        [
                            'queue_2',
                            'exchange_2',
                            'key_2',
                        ],
                        [
                            'queue_3',
                            'exchange_3',
                            'key_3',
                        ],
                    ],
                ))(),
            )
        ;

        foreach (
            Declaration::new()
                ->withoutBinding('exchange_1', 'queue_1', 'key_1')
                ->withoutBinding('exchange_2', 'queue_2', 'key_2')
                ->withoutBinding('exchange_3', 'queue_3', 'key_3')
                ->finish()->unbindings() as $binding
        ) {
            $binding->unbind($ch);
        }
    }
}
