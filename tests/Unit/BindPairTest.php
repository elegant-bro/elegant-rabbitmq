<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Unit;

use ElegantBro\RabbitMQ\BindPair;
use PHPUnit\Framework\TestCase;

final class BindPairTest extends TestCase
{
    public function testExchange(): void
    {
        self::assertSame(
            'test_exchange',
            (new BindPair('test_exchange', 'test_key'))->exchange(),
        );
    }

    public function testKey(): void
    {
        self::assertSame(
            'test_key',
            (new BindPair('test_exchange', 'test_key'))->key(),
        );
    }
}
