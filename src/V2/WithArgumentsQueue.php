<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use function array_merge_recursive;

final class WithArgumentsQueue implements Queue
{
    /**
     * @var array<string, mixed>
     */
    private array $args;

    private Queue $original;

    /**
     * @param array<string, mixed> $args
     */
    public function __construct(array $args, Queue $original)
    {
        $this->args = $args;
        $this->original = $original;
    }

    public function asArray(): array
    {
        $q = $this->original->asArray();
        $q['args'] = array_merge_recursive(
            $this->args,
            $q['args'] ?? [],
        );
        return $q;
    }
}
