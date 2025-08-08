<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2;

use PhpAmqpLib\Channel\AMQPChannel;

interface RabbitRPC
{
    public function call(AMQPChannel $ch): void;
}
