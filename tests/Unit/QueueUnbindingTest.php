<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Unit;

use Codeception\Stub;
use Codeception\Test\Unit;
use ElegantBro\RabbitMQ\QueueUnbinding;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;

final class QueueUnbindingTest extends Unit
{
    /**
     * @throws Exception
     */
    public function testBind(): void
    {
        $ch = Stub::makeEmpty(AMQPChannel::class);
        $ch
            ->expects($this->once())
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
