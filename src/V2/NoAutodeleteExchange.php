<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

final class NoAutodeleteExchange implements Exchange
{
    private Exchange $original;

    public function __construct(Exchange $original)
    {
        $this->original = $original;
    }

    public function asArray(): array
    {
        $e = $this->original->asArray();
        $e['auto_delete'] = false;
        return $e;
    }
}
