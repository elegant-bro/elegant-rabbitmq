<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

interface Exchange
{
    /**
     * @return array{
     *  name: string,
     *  type: string,
     *  passive: bool,
     *  durable: bool,
     *  auto_delete: bool
     *  }
     */
    public function asArray(): array;
}
