<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Wire\AMQPTable;

interface Queue
{
    /**
     * @return array{
     *  name: string,
     *  passive: bool,
     *  durable: bool,
     *  exclusive: bool,
     *  auto_delete: bool,
     *  nowait: bool,
     *  args: null|AMQPTable|array<string, mixed>
     *  }
     */
    public function asArray(): array;
}
