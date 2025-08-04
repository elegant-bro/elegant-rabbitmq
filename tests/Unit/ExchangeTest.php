<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Unit;

use Codeception\Stub;
use Codeception\Test\Unit;
use ElegantBro\RabbitMQ\Exchange;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;

final class ExchangeTest extends Unit
{
    /**
     * @throws Exception
     */
    public function testDeclare(): void
    {
        $ch = Stub::makeEmpty(AMQPChannel::class);
        $ch
            ->expects($this->once())
            ->method('exchange_declare')
            ->with(
                'test_exchange',
                'direct',
                false,
                true,
                false,
            )
        ;

        (new Exchange('test_exchange', 'direct', false, true, false))->declare($ch);
    }

    /**
     * @throws Exception
     */
    public function testDelete(): void
    {
        $ch = Stub::makeEmpty(AMQPChannel::class);
        $ch
            ->expects($this->once())
            ->method('exchange_delete')
            ->with('test_exchange')
        ;

        (new Exchange('test_exchange', 'direct', false, true, false))->delete($ch);
    }
}
