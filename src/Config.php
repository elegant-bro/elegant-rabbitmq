<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

final readonly class Config
{
    /**
     * @param Exchange[] $exchanges
     * @param Queue[] $queues
     * @param QueueBinding[] $bindings
     * @param QueueUnbinding[] $unbindings
     */
    public function __construct(
        private array $exchanges,
        private array $queues,
        private array $bindings,
        private array $unbindings,
        private array $deletingExchanges,
        private array $deletingQueues,
    ) {}

    /**
     * @return Exchange[]
     */
    public function exchanges(): array
    {
        return $this->exchanges;
    }

    /**
     * @return Queue[]
     */
    public function queues(): array
    {
        return $this->queues;
    }

    /**
     * @return QueueBinding[]
     */
    public function bindings(): array
    {
        return $this->bindings;
    }

    /**
     * @return QueueUnbinding[]
     */
    public function unbindings(): array
    {
        return $this->unbindings;
    }

    /**
     * @return Exchange[]
     */
    public function deletingExchanges(): array
    {
        return $this->deletingExchanges;
    }

    /**
     * @return Queue[]
     */
    public function deletingQueues(): array
    {
        return $this->deletingQueues;
    }
}
