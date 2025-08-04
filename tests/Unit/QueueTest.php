<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Unit;

use Codeception\Stub;
use Codeception\Test\Unit;
use ElegantBro\RabbitMQ\Queue;
use PhpAmqpLib\Channel\AMQPChannel;

final class QueueTest extends Unit
{
    public function testDeclare(): void
    {
        $ch = Stub::makeEmpty(AMQPChannel::class);
        $ch
            ->expects($this->once())
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

    public function testDelete(): void
    {
        $ch = Stub::makeEmpty(AMQPChannel::class);
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
