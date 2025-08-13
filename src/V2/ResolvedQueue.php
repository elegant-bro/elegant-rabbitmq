<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

final class ResolvedQueue implements Queue
{
    private Queue $original;

    /**
     * @var null|array{
     *   name: string,
     *   passive: bool,
     *   durable: bool,
     *   exclusive: bool,
     *   auto_delete: bool,
     *   nowait: bool,
     *   args: null|array<string, mixed>
     *   }
     */
    private ?array $resolvedSpecs = null;

    public function __construct(
        Queue $original
    ) {
        $this->original = $original;
    }

    public function asArray(): array
    {
        if (null === $this->resolvedSpecs) {
            $this->resolvedSpecs = $this->original->asArray();
        }

        return $this->resolvedSpecs;
    }
}
