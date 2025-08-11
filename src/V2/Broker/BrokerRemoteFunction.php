<?php

declare(strict_types=1);

namespace ElegantBro\RabbitMQ\V2\Broker;

use PhpAmqpLib\Channel\AMQPChannel;

interface BrokerRemoteFunction
{
    public function call(AMQPChannel $ch): void;
}
