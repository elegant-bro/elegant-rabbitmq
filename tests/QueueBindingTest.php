<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests;

use ElegantBro\RabbitMQ\QueueBinding;
use PhpAmqpLib\Channel\AMQPChannel;
use PHPUnit\Framework\TestCase;
use Throwable;
use function PHPUnit\Framework\once;

final class QueueBindingTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testBind(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(once())
            ->method('queue_bind')
            ->with(
                'test_queue',
                'test_exchange',
                'test_key',
                false,
                ['foo' => 'bar'],
            )
        ;

        (new QueueBinding('test_queue', 'test_exchange', 'test_key', false, ['foo' => 'bar']))->bind($ch);
    }
}
