<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Wire\AMQPTable;

final class Declaration
{
    /**
     * @var array{
     * exchanges: Exchange[],
     * queues: Queue[],
     * bindings: QueueBinding[],
     * unbindings: QueueUnbinding[],
     * deletingExchanges: Exchange[],
     * deletingQueues: Queue[],
     * }
     */
    private array $d;

    public static function new(): self
    {
        return new self(
            [
                'exchanges' => [],
                'queues' => [],
                'bindings' => [],
                'unbindings' => [],
                'deletingExchanges' => [],
                'deletingQueues' => [],
            ],
        );
    }

    /**
     * @param array{
     *     exchanges: Exchange[],
     *     queues: Queue[],
     *     bindings: QueueBinding[],
     *     unbindings: QueueUnbinding[],
     *     deletingExchanges: Exchange[],
     *     deletingQueues: Queue[],
     * } $d
     */
    public function __construct(
        array $d
    ) {
        $this->d = $d;
    }

    public function finish(): Config
    {
        return new Config(
            $this->d['exchanges'],
            $this->d['queues'],
            $this->d['bindings'],
            $this->d['unbindings'],
            $this->d['deletingExchanges'],
            $this->d['deletingQueues'],
        );
    }

    public function withExchange(string $name, string $type, bool $passive = false, bool $durable = true, bool $autoDelete = false): self
    {
        $d = $this->d;
        $d['exchanges'][] =
            new Exchange(
                $name,
                $type,
                $passive,
                $durable,
                $autoDelete,
            );

        return new self($d);
    }

    /**
     * @param null|array<string, mixed>|AMQPTable $args
     */
    public function withQueue(string $name, bool $passive = false, bool $durable = true, bool $exclusive = false, bool $autoDelete = false, bool $noWait = false, $args = null): self
    {
        $d = $this->d;

        $d['queues'][] = new Queue(
            $name,
            $passive,
            $durable,
            $exclusive,
            $autoDelete,
            $noWait,
            $args,
        );

        return new self($d);
    }

    /**
     * @param null|array<string, mixed>|AMQPTable $args
     */
    private function withBinding(string $queue, string $exchange, string $key, bool $nowait = false, $args = null): self
    {
        $d = $this->d;

        $d['bindings'][] = new QueueBinding(
            $queue,
            $exchange,
            $key,
            $nowait,
            $args,
        );

        return new self($d);
    }

    /**
     * @param null|array<string, mixed>|AMQPTable $args
     */
    private function withoutBinding(string $queue, string $exchange, string $key, $args = null): self
    {
        $d = $this->d;

        $d['unbindings'][] = new QueueUnbinding(
            $queue,
            $exchange,
            $key,
            $args,
        );

        return new self($d);
    }

    /**
     * @param iterable<BindPair> $bindPairs
     * @param null|array<string, mixed>|AMQPTable $args
     */
    public function bindToQueue(string $queue, iterable $bindPairs, bool $nowait = false, $args = null): self
    {
        $d = $this;

        foreach ($bindPairs as $pair) {
            $d = $d->withBinding($queue, $pair->exchange(), $pair->key(), $nowait, $args);
        }

        return $d;
    }

    /**
     * @param iterable<BindPair> $unbindPairs
     */
    public function unbindFromQueue(string $queue, iterable $unbindPairs, array $args = []): self
    {
        $d = $this;
        foreach ($unbindPairs as $pair) {
            $d = $this->withoutBinding($queue, $pair->exchange(), $pair->key(), $args);
        }

        return $d;
    }

    public function withoutExchange(string $exchange): self
    {
        $d = $this->d;

        $d['deletingExchanges'][] = new Exchange($exchange, '', false, true, false);

        return new self($d);
    }

    public function withoutQueue(string $queue): self
    {
        $d = $this->d;

        $d['deletingQueues'][] = new Queue($queue, false, true, false, false, false, null);

        return new self($d);
    }
}
