<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

final class NoAutodeleteQueue implements Queue
{
    private Queue $original;

    public function __construct(Queue $original)
    {
        $this->original = $original;
    }

    public function asArray(): array
    {
        $q = $this->original->asArray();
        $q['auto_delete'] = false;
        return $q;
    }
}
