<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

final class JustExchange implements Exchange
{
    /**
     * @var array{
     * name: string,
     * type: string,
     * passive: bool,
     * durable: bool,
     * auto_delete: bool
     * }
     */
    private array $args;

    public static function default(string $name, string $type): Exchange
    {
        return new self(
            $name,
            $type,
            false,
            false,
            true,
        );
    }

    public function __construct(
        string $name,
        string $type,
        bool $passive,
        bool $durable,
        bool $autoDelete
    ) {
        $this->args['name'] = $name;
        $this->args['type'] = $type;
        $this->args['passive'] = $passive;
        $this->args['durable'] = $durable;
        $this->args['auto_delete'] = $autoDelete;
    }

    public function asArray(): array
    {
        return $this->args;
    }
}
