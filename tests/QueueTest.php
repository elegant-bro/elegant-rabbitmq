<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests;

use ElegantBro\RabbitMQ\Queue;
use PhpAmqpLib\Channel\AMQPChannel;
use PHPUnit\Framework\TestCase;
use Throwable;
use function PHPUnit\Framework\once;

final class QueueTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testDeclare(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(once())
            ->method('queue_declare')
            ->with(
                'test_queue',
                false,
                true,
                false,
                false,
                false,
                ['foo' => 'bar'],
            )
        ;

        (new Queue('test_queue', false, true, false, false, false, ['foo' => 'bar']))->declare($ch);
    }

    /**
     * @throws Throwable
     */
    public function testDelete(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects($this->once())
            ->method('queue_delete')
            ->with(
                'test_queue',
            )
        ;

        (new Queue('test_queue', false, true, false, false, false, ['foo' => 'bar']))->delete($ch);
    }
}
