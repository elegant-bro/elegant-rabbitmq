<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Wire\AMQPTable;

final class JustQueue implements Queue
{
    /**
     * @var array{
     * name: string,
     * passive: bool,
     * durable: bool,
     * exclusive: bool,
     * auto_delete: bool,
     * nowait: bool,
     * args: null|AMQPTable|array<string, mixed>
     * }
     */
    private array $args;

    public static function default(string $name): Queue
    {
        return new self(
            $name,
            false,
            false,
            false,
            true,
            false,
            null,
        );
    }

    /**
     * @param null|AMQPTable|array<string, mixed> $args
     */
    public function __construct(
        string $name,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete,
        bool $nowait,
        $args = null
    ) {
        $this->args['name'] = $name;
        $this->args['passive'] = $passive;
        $this->args['durable'] = $durable;
        $this->args['exclusive'] = $exclusive;
        $this->args['auto_delete'] = $autoDelete;
        $this->args['nowait'] = $nowait;
        $this->args['args'] = $args;
    }

    public function asArray(): array
    {
        return $this->args;
    }
}
