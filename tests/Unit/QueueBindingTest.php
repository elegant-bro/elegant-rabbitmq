<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Unit;

use Codeception\Stub;
use Codeception\Test\Unit;
use ElegantBro\RabbitMQ\QueueBinding;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;

final class QueueBindingTest extends Unit
{
    /**
     * @throws Exception
     */
    public function testBind(): void
    {
        $ch = Stub::makeEmpty(AMQPChannel::class);
        $ch
            ->expects($this->once())
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
