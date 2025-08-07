<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests;

use ElegantBro\RabbitMQ\Exchange;
use PhpAmqpLib\Channel\AMQPChannel;
use PHPUnit\Framework\TestCase;
use Throwable;
use function PHPUnit\Framework\once;

final class ExchangeTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testDeclare(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(once())
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
     * @throws Throwable
     */
    public function testDelete(): void
    {
        $ch = $this->createMock(AMQPChannel::class);
        $ch
            ->expects(once())
            ->method('exchange_delete')
            ->with('test_exchange')
        ;

        (new Exchange('test_exchange', 'direct', false, true, false))->delete($ch);
    }
}
