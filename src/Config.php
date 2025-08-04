<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

final class Config
{
    /**
     * @var Exchange[]
     */
    private array $exchanges;

    /**
     * @var Queue[]
     */
    private array $queues;

    /**
     * @var QueueBinding[]
     */
    private array $bindings;

    /**
     * @var QueueUnbinding[]
     */
    private array $unbindings;

    /**
     * @var Exchange[]
     */
    private array $deletingExchanges;

    /**
     * @var Queue[]
     */
    private array $deletingQueues;

    /**
     * @param Exchange[] $exchanges
     * @param Queue[] $queues
     * @param QueueBinding[] $bindings
     * @param QueueUnbinding[] $unbindings
     */
    public function __construct(
        array $exchanges,
        array $queues,
        array $bindings,
        array $unbindings,
        array $deletingExchanges,
        array $deletingQueues
    ) {
        $this->exchanges = $exchanges;
        $this->queues = $queues;
        $this->bindings = $bindings;
        $this->unbindings = $unbindings;
        $this->deletingExchanges = $deletingExchanges;
        $this->deletingQueues = $deletingQueues;
    }

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
