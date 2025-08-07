<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\Tests\Support;

use PHPUnit\Framework\Constraint\Callback;

interface WithConsecutive
{
    /**
     * @return array<int, Callback<*>>
     */
    public function __invoke(): array;
}
