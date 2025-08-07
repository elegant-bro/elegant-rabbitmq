<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests;

use ElegantBro\RabbitMQ\QueueUnbinding;
use PhpAmqpLib\Channel\AMQPChannel;
use PHPUnit\Framework\TestCase;
use Throwable;
use function PHPUnit\Framework\once;

final class QueueUnbindingTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testBind(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(once())
            ->method('queue_unbind')
            ->with(
                'test_queue',
                'test_exchange',
                'test_key',
                ['foo' => 'bar'],
            )
        ;

        (new QueueUnbinding('test_queue', 'test_exchange', 'test_key', ['foo' => 'bar']))->unbind($ch);
    }
}
