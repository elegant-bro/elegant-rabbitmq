<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ;

use PhpAmqpLib\Wire\AMQPTable;
use function array_merge;

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

    public function withFanoutExchange(string $name, bool $durable = true): self
    {
        return $this->withExchange($name, 'fanout', $durable);
    }

    public function withDirectExchange(string $name, bool $durable = true): self
    {
        return $this->withExchange($name, 'direct', $durable);
    }

    public function withTopicExchange(string $name, bool $durable = true): self
    {
        return $this->withExchange($name, 'topic', $durable);
    }

    public function withExchange(string $name, string $type, bool $durable = true): self
    {
        $d = $this->d;
        $d['exchanges'][] =
            new Exchange(
                $name,
                $type,
                false,
                $durable,
                false,
            );

        return new self($d);
    }

    public function withQueue(string $name, bool $durable, ?AMQPTable $args = null): self
    {
        $d = $this->d;

        $d['queues'][] = new Queue(
            $name,
            false,
            $durable,
            false,
            false,
            false,
            $args,
        );

        return new self($d);
    }

    public function withDurableQueue(string $name, ?AMQPTable $args = null): self
    {
        return $this->withQueue($name, true, $args);
    }

    public function withQueueBinding(string $queue, BindPair $pair): self
    {
        $d = $this->d;

        $d['bindings'][] = new QueueBinding(
            $queue,
            $pair->exchange(),
            $pair->key(),
            false,
            null,
        );

        return new self($d);
    }

    public function withBinding(string $exchange, string $queue, string $key = ''): self
    {
        $d = $this->d;

        $d['bindings'][] = new QueueBinding(
            $queue,
            $exchange,
            $key,
            false,
            null,
        );

        return new self($d);
    }

    public function withoutBinding(string $exchange, string $queue, string $key = ''): self
    {
        $d = $this->d;

        $d['unbindings'][] = new QueueUnbinding(
            $queue,
            $exchange,
            $key,
            null,
        );

        return new self($d);
    }

    public function withOutputRetryExchange(string $exchange): self
    {
        return $this->withDirectExchange($exchange . '_out_dlx');
    }

    public function withDLXRetryTopology(string $exchange, int $ttl): self
    {
        return $this
            ->withFanoutExchange($in = $exchange . '_in_dlx')
            ->withQueue(
                $qDlx = $exchange . '.q_dlx',
                true,
                new AMQPTable(
                    [
                        'x-dead-letter-exchange' => $exchange . '_out_dlx',
                        'x-message-ttl' => $ttl,
                    ],
                ),
            )
            ->withBinding($in, $qDlx)
        ;
    }

    /**
     * @param BindPair[] $bindPairs
     */
    public function withQueueBindRetry(string $name, string $retPref, array $bindPairs): self
    {
        $d = $this->withQueue($name, true);
        foreach ($bindPairs as $pair) {
            $d = $d
                ->withBinding($pair->exchange(), $name, $pair->key())
            ;
        }

        return $d->withBinding($retPref . '_out_dlx', $name, $name);
    }

    /**
     * @param BindPair[] $bindPairs
     */
    public function withQueueBindDLXRetry(string $name, string $retPref, array $bindPairs, array $qArgs = []): self
    {
        $d = $this->withQueue(
            $name,
            true,
            new AMQPTable(
                array_merge(
                    [
                        'x-dead-letter-exchange' => $retPref . '_in_dlx',
                        'x-dead-letter-routing-key' => $name,
                    ],
                    $qArgs,
                ),
            ),
        );
        foreach ($bindPairs as $pair) {
            $d = $d
                ->withBinding($pair->exchange(), $name, $pair->key())
            ;
        }

        return $d->withBinding($retPref . '_out_dlx', $name, $name);
    }

    /**
     * @param BindPair[] $bindPairs
     */
    public function withQueueBind(string $name, bool $durable, array $bindPairs, array $qArgs = []): self
    {
        $d = $this->withQueue(
            $name,
            $durable,
            new AMQPTable($qArgs),
        );

        foreach ($bindPairs as $pair) {
            $d = $d->withBinding($pair->exchange(), $name, $pair->key());
        }

        return $d;
    }

    public function unbindFromQueue(string $name, array $unbindPairs): self
    {
        $d = $this;
        foreach ($unbindPairs as $pair) {
            $d = $this->withoutBinding($pair->exchange(), $name, $pair->key());
        }

        return $d;
    }

    public function withoutExchange(
        string $exchange
    ): self {
        $d = $this->d;

        $d['deletingExchanges'][] = new Exchange($exchange, '', false, true, false);

        return new self($d);
    }

    public function withoutOutputRetryExchange(
        string $exchange
    ): self {
        $d = $this->d;

        $d['deletingExchanges'][] = new Exchange($exchange . '_out_dlx', '', false, true, false);

        return new self($d);
    }

    public function withoutDLXRetryTopology(
        string $exchange
    ): self {
        $d = $this->d;

        $d['deletingExchanges'][] = new Exchange($exchange . '_in_dlx', '', false, true, false);
        $d['deletingQueues'][] = new Queue($exchange . '.q_dlx', false, true, false, false, false, []);

        return new self($d);
    }

    public function withoutQueue(
        string $name
    ): self {
        $d = $this->d;

        $d['deletingQueues'][] = new Queue($name . '.q_dlx', false, true, false, false, false, []);

        return new self($d);
    }
}
